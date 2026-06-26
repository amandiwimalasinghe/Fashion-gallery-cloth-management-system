<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
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
            'role' => 'required|in:admin,user,designer,tailor',
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
