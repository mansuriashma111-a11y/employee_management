<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10',
            'password' => 'required|min:6',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imageName = time() . '.' . $request->profile_image->extension();

        $request->profile_image->move(
            public_path('uploads/profile'),
            $imageName
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_image' => $imageName,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registration successful!'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }

        $request->session()->regenerate();

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'profile_image' => $user->profile_image,
            'role' => $user->role,
            'logged_in' => true
        ]);

        if ($user->role === 'admin') {
            $redirect = route('admin.dashboard');
        } elseif ($user->role === 'employee') {
            $redirect = route('employee.dashboard');
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid user role.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'redirect' => $redirect
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.store');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function employeeDashboard()
    {
        return view('employee.dashboard');
    }

    public function profile()
    {
        $user = DB::table('users')
            ->where('id', session('user_id'))
            ->first();

        return view('profile', compact('user'));
    }

    public function editProfile()
    {
        $user = DB::table('users')
            ->where('id', session('user_id'))
            ->first();

        return view('profile_edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = DB::table('users')
            ->where('id', session('user_id'))
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $imageName = $user->profile_image;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/profile'),
                $imageName
            );
        }

        DB::table('users')
            ->where('id', session('user_id'))
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'profile_image' => $imageName,
                'updated_at' => now(),
            ]);

        session([
            'user_name' => $request->name,
            'profile_image' => $imageName
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }
}