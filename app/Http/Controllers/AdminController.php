<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        return view('admin.dashboard', compact('totalUsers', 'totalOrders'));
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
