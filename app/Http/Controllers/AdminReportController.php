<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $orderQuery = Order::query();
        if ($from) {
            $orderQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $orderQuery->whereDate('created_at', '<=', $to);
        }

        $totalOrders = (clone $orderQuery)->count();
        $validOrderQuery = (clone $orderQuery)->where('status', '!=', 'cancelled');
        $totalRevenue = (clone $validOrderQuery)->sum('total_amount');
        $validOrdersCount = (clone $validOrderQuery)->count();
        $averageOrderValue = $validOrdersCount > 0 ? $totalRevenue / $validOrdersCount : 0;
        $cancelledOrders = (clone $orderQuery)->where('status', 'cancelled')->count();

        $statusBreakdown = (clone $orderQuery)
            ->select('status', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('status')
            ->get();

        $paymentBreakdown = (clone $validOrderQuery)
            ->select('payment_method', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('payment_method')
            ->get();

        $monthlySales = (clone $validOrderQuery)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        $topProductsQuery = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('users', 'products.user_id', '=', 'users.id')
            ->where('orders.status', '!=', 'cancelled');

        if ($from) {
            $topProductsQuery->whereDate('orders.created_at', '>=', $from);
        }
        if ($to) {
            $topProductsQuery->whereDate('orders.created_at', '<=', $to);
        }

        $topProducts = $topProductsQuery
            ->select(
                'products.id',
                'products.name',
                'products.category',
                'users.name as designer_name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->groupBy('products.id', 'products.name', 'products.category', 'users.name')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        return view('admin.reports.sales', compact(
            'from',
            'to',
            'totalOrders',
            'totalRevenue',
            'averageOrderValue',
            'cancelledOrders',
            'statusBreakdown',
            'paymentBreakdown',
            'monthlySales',
            'topProducts'
        ));
    }

    public function designers(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $designers = User::where('role', 'designer')->withCount('products')->get();

        $salesQuery = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'cancelled');

        if ($from) {
            $salesQuery->whereDate('orders.created_at', '>=', $from);
        }
        if ($to) {
            $salesQuery->whereDate('orders.created_at', '<=', $to);
        }

        $salesByDesigner = $salesQuery
            ->select(
                'products.user_id as designer_id',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_items.quantity) as items_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('products.user_id')
            ->get()
            ->keyBy('designer_id');

        $reviewsQuery = Review::query()
            ->join('products', 'reviews.product_id', '=', 'products.id');

        if ($from) {
            $reviewsQuery->whereDate('reviews.created_at', '>=', $from);
        }
        if ($to) {
            $reviewsQuery->whereDate('reviews.created_at', '<=', $to);
        }

        $reviewsByDesigner = $reviewsQuery
            ->select(
                'products.user_id as designer_id',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->groupBy('products.user_id')
            ->get()
            ->keyBy('designer_id');

        $designerStats = $designers->map(function ($designer) use ($salesByDesigner, $reviewsByDesigner) {
            $sales = $salesByDesigner->get($designer->id);
            $reviews = $reviewsByDesigner->get($designer->id);

            return (object) [
                'id' => $designer->id,
                'name' => $designer->name,
                'email' => $designer->email,
                'company_name' => $designer->company_name,
                'products_count' => $designer->products_count,
                'total_orders' => (int) ($sales->total_orders ?? 0),
                'items_sold' => (int) ($sales->items_sold ?? 0),
                'total_revenue' => (float) ($sales->total_revenue ?? 0),
                'review_count' => (int) ($reviews->review_count ?? 0),
                'avg_rating' => $reviews ? round((float) $reviews->avg_rating, 1) : 0,
            ];
        })->sortByDesc('total_revenue')->values();

        $totalDesigners = $designerStats->count();
        $totalProducts = $designerStats->sum('products_count');
        $totalDesignerRevenue = $designerStats->sum('total_revenue');
        $ratedDesigners = $designerStats->where('review_count', '>', 0);
        $overallAvgRating = $ratedDesigners->count() > 0 ? round($ratedDesigners->avg('avg_rating'), 1) : 0;

        return view('admin.reports.designers', compact(
            'from',
            'to',
            'designerStats',
            'totalDesigners',
            'totalProducts',
            'totalDesignerRevenue',
            'overallAvgRating'
        ));
    }

    public function customers(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $customers = User::where('role', 'customer')->get();

        $ordersQuery = Order::query();
        if ($from) {
            $ordersQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $ordersQuery->whereDate('created_at', '<=', $to);
        }

        $ordersByCustomer = $ordersQuery
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_orders"),
                DB::raw("SUM(CASE WHEN status != 'cancelled' THEN total_amount ELSE 0 END) as total_spent"),
                DB::raw('MAX(created_at) as last_order_at')
            )
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $customerStats = $customers->map(function ($customer) use ($ordersByCustomer) {
            $orders = $ordersByCustomer->get($customer->id);

            return (object) [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'created_at' => $customer->created_at,
                'total_orders' => (int) ($orders->total_orders ?? 0),
                'completed_orders' => (int) ($orders->completed_orders ?? 0),
                'total_spent' => (float) ($orders->total_spent ?? 0),
                'last_order_at' => $orders->last_order_at ?? null,
            ];
        })->sortByDesc('total_spent')->values();

        $totalCustomers = $customerStats->count();
        $activeBuyers = $customerStats->where('total_orders', '>', 0)->count();
        $newCustomersQuery = User::where('role', 'customer');
        if ($from) {
            $newCustomersQuery->whereDate('created_at', '>=', $from);
        } else {
            $newCustomersQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        }
        if ($to) {
            $newCustomersQuery->whereDate('created_at', '<=', $to);
        }
        $newCustomers = $newCustomersQuery->count();
        $totalCustomerSpend = $customerStats->sum('total_spent');

        return view('admin.reports.customers', compact(
            'from',
            'to',
            'customerStats',
            'totalCustomers',
            'activeBuyers',
            'newCustomers',
            'totalCustomerSpend'
        ));
    }

    public function reviews(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $rating = $request->input('rating');

        $baseQuery = Review::query();
        if ($from) {
            $baseQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $baseQuery->whereDate('created_at', '<=', $to);
        }

        $totalReviews = (clone $baseQuery)->count();
        $averageRating = $totalReviews > 0 ? round((float) (clone $baseQuery)->avg('rating'), 1) : 0;
        $fiveStarCount = (clone $baseQuery)->where('rating', 5)->count();
        $lowRatingCount = (clone $baseQuery)->where('rating', '<=', 2)->count();

        $ratingCounts = (clone $baseQuery)
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating');

        $ratingDistribution = [];
        for ($star = 5; $star >= 1; $star--) {
            $count = (int) ($ratingCounts[$star] ?? 0);
            $ratingDistribution[$star] = [
                'count' => $count,
                'percent' => $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0,
            ];
        }

        $productRatingsQuery = Review::query()
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->leftJoin('users', 'products.user_id', '=', 'users.id');
        if ($from) {
            $productRatingsQuery->whereDate('reviews.created_at', '>=', $from);
        }
        if ($to) {
            $productRatingsQuery->whereDate('reviews.created_at', '<=', $to);
        }

        $productRatings = $productRatingsQuery
            ->select(
                'products.id',
                'products.name',
                'users.name as designer_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('AVG(reviews.rating) as avg_rating')
            )
            ->groupBy('products.id', 'products.name', 'users.name')
            ->orderByDesc('avg_rating')
            ->orderByDesc('review_count')
            ->limit(10)
            ->get();

        $reviewsQuery = (clone $baseQuery)->with(['user', 'product.user'])->latest();
        if ($rating) {
            $reviewsQuery->where('rating', $rating);
        }
        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        return view('admin.reports.reviews', compact(
            'from',
            'to',
            'rating',
            'totalReviews',
            'averageRating',
            'fiveStarCount',
            'lowRatingCount',
            'ratingDistribution',
            'productRatings',
            'reviews'
        ));
    }

    public function inquiries(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $status = $request->input('status');

        $baseQuery = ProductInquiry::query();
        if ($from) {
            $baseQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $baseQuery->whereDate('created_at', '<=', $to);
        }

        $totalInquiries = (clone $baseQuery)->count();
        $pendingInquiries = (clone $baseQuery)->where('status', 'pending')->count();
        $processingInquiries = (clone $baseQuery)->where('status', 'processing')->count();
        $resolvedInquiries = (clone $baseQuery)->where('status', 'resolved')->count();
        $resolutionRate = $totalInquiries > 0 ? round(($resolvedInquiries / $totalInquiries) * 100) : 0;

        $topInquiredQuery = ProductInquiry::query()
            ->join('products', 'product_inquiries.product_id', '=', 'products.id')
            ->leftJoin('users', 'products.user_id', '=', 'users.id');
        if ($from) {
            $topInquiredQuery->whereDate('product_inquiries.created_at', '>=', $from);
        }
        if ($to) {
            $topInquiredQuery->whereDate('product_inquiries.created_at', '<=', $to);
        }

        $topInquiredProducts = $topInquiredQuery
            ->select(
                'products.id',
                'products.name',
                'users.name as designer_name',
                DB::raw('COUNT(product_inquiries.id) as inquiry_count'),
                DB::raw("SUM(CASE WHEN product_inquiries.status = 'resolved' THEN 1 ELSE 0 END) as resolved_count")
            )
            ->groupBy('products.id', 'products.name', 'users.name')
            ->orderByDesc('inquiry_count')
            ->limit(10)
            ->get();

        $inquiriesQuery = (clone $baseQuery)->with(['user', 'product', 'order'])->latest();
        if ($status) {
            $inquiriesQuery->where('status', $status);
        }
        $inquiries = $inquiriesQuery->paginate(10)->withQueryString();

        return view('admin.reports.inquiries', compact(
            'from',
            'to',
            'status',
            'totalInquiries',
            'pendingInquiries',
            'processingInquiries',
            'resolvedInquiries',
            'resolutionRate',
            'topInquiredProducts',
            'inquiries'
        ));
    }
}
