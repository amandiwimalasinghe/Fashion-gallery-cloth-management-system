<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        return view('admin.dashboard', compact('totalUsers', 'totalOrders'));
    }

    public function overview(Request $request)
    {
        // ===== Filters =====
        $period = $request->input('period', 'all');
        $designerId = $request->input('designer');
        $paymentMethod = $request->input('payment');
        $category = $request->input('category');

        [$start, $end] = match ($period) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            '7days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            '30days' => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
            'month' => [now()->startOfMonth(), now()->endOfDay()],
            'year' => [now()->startOfYear(), now()->endOfDay()],
            'custom' => [
                $request->filled('from') ? \Carbon\Carbon::parse($request->from)->startOfDay() : null,
                $request->filled('to') ? \Carbon\Carbon::parse($request->to)->endOfDay() : null,
            ],
            default => [null, null],
        };

        $applyDates = function ($query, $column = 'created_at') use ($start, $end) {
            if ($start) {
                $query->where($column, '>=', $start);
            }
            if ($end) {
                $query->where($column, '<=', $end);
            }
            return $query;
        };

        // Orders are split per designer at checkout, so filtering by item designer keeps totals accurate.
        $orderBase = function () use ($applyDates, $designerId, $paymentMethod, $category) {
            $q = Order::query();
            $applyDates($q);
            if ($designerId) {
                $q->whereHas('items.product', fn ($p) => $p->where('user_id', $designerId));
            }
            if ($category) {
                $q->whereHas('items.product', fn ($p) => $p->where('category', $category));
            }
            if ($paymentMethod) {
                $q->where('payment_method', $paymentMethod);
            }
            return $q;
        };

        $productBase = function () use ($designerId, $category) {
            $q = Product::query();
            if ($designerId) {
                $q->where('user_id', $designerId);
            }
            if ($category) {
                $q->where('category', $category);
            }
            return $q;
        };

        $totalRevenue = $orderBase()->where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = $orderBase()->count();
        $pendingOrders = $orderBase()->where('status', 'pending')->count();

        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalDesigners = User::where('role', 'designer')->count();
        $newUsers = $applyDates(User::query())->count();

        $totalProducts = $productBase()->count();
        $lowStockCount = $productBase()->where('stock_quantity', '<=', 5)->count();

        $inquiryQuery = $applyDates(ProductInquiry::where('status', 'pending'));
        $reviewQuery = $applyDates(Review::query());
        if ($designerId || $category) {
            $productFilter = function ($p) use ($designerId, $category) {
                if ($designerId) {
                    $p->where('user_id', $designerId);
                }
                if ($category) {
                    $p->where('category', $category);
                }
            };
            $inquiryQuery->whereHas('product', $productFilter);
            $reviewQuery->whereHas('product', $productFilter);
        }
        $pendingInquiries = $inquiryQuery->count();
        $averageRating = round((float) ($reviewQuery->avg('rating') ?? 0), 1);

        // ===== Trend chart (daily for short ranges, monthly otherwise) =====
        $chartStart = $start ?? now()->subMonths(5)->startOfMonth();
        $chartEnd = $end ?? now()->endOfDay();
        $daily = $chartStart->diffInDays($chartEnd) <= 62;

        $sqlFormat = $daily ? '%Y-%m-%d' : '%Y-%m';
        $trendData = $orderBase()
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $chartStart)
            ->where('created_at', '<=', $chartEnd)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '{$sqlFormat}') as bucket"),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('bucket')
            ->get()
            ->keyBy('bucket');

        $buckets = collect();
        $cursor = $daily ? $chartStart->copy()->startOfDay() : $chartStart->copy()->startOfMonth();
        while ($cursor <= $chartEnd) {
            $buckets->push($cursor->copy());
            $daily ? $cursor->addDay() : $cursor->addMonth();
        }

        $chartLabels = $buckets->map(fn ($d) => $daily ? $d->format('M d') : $d->format('M Y'))->values();
        $chartRevenues = $buckets->map(fn ($d) => (float) ($trendData->get($d->format($daily ? 'Y-m-d' : 'Y-m'))->revenue ?? 0))->values();
        $chartOrders = $buckets->map(fn ($d) => (int) ($trendData->get($d->format($daily ? 'Y-m-d' : 'Y-m'))->orders ?? 0))->values();
        $chartSubtitle = $daily ? 'Daily breakdown' : 'Monthly breakdown';

        // Order status counts
        $statusCounts = $orderBase()->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentOrders = $orderBase()->with('user')->latest()->take(5)->get();
        $recentUsers = $applyDates(User::query())->latest()->take(5)->get();
        $lowStockProducts = $productBase()->with('user')
            ->where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        // Filter options
        $designers = User::where('role', 'designer')->orderBy('name')->get(['id', 'name']);
        $categories = Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        $paymentMethods = Order::whereNotNull('payment_method')->distinct()->pluck('payment_method');

        $periodLabels = [
            'all' => 'All Time',
            'today' => 'Today',
            '7days' => 'Last 7 Days',
            '30days' => 'Last 30 Days',
            'month' => 'This Month',
            'year' => 'This Year',
            'custom' => 'Custom Range',
        ];
        $activeFilters = collect([
            $period !== 'all' ? ($period === 'custom'
                ? 'Date: ' . ($start?->format('M d, Y') ?? 'Start') . ' – ' . ($end?->format('M d, Y') ?? 'Today')
                : 'Period: ' . ($periodLabels[$period] ?? $period)) : null,
            $designerId ? 'Designer: ' . optional($designers->firstWhere('id', (int) $designerId))->name : null,
            $category ? 'Category: ' . $category : null,
            $paymentMethod ? 'Payment: ' . strtoupper($paymentMethod) : null,
        ])->filter()->values();

        return view('admin.overview', compact(
            'period',
            'designerId',
            'paymentMethod',
            'category',
            'designers',
            'categories',
            'paymentMethods',
            'periodLabels',
            'activeFilters',
            'newUsers',
            'chartSubtitle',
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'totalUsers',
            'totalCustomers',
            'totalDesigners',
            'totalProducts',
            'lowStockCount',
            'pendingInquiries',
            'averageRating',
            'chartLabels',
            'chartRevenues',
            'chartOrders',
            'statusCounts',
            'recentOrders',
            'recentUsers',
            'lowStockProducts'
        ));
    }

    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items.product.user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue'
        ));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user', 'items.product.user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:customer,designer,admin',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;


        if($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }


    public function destroy($id)
    {
        
        if(auth()->id() == $id) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}
