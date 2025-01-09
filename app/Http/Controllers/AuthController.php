<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create User
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Đặt mặc định là 'customer'
        ]);
    
        // Redirect với thông báo thành công
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập người dùng
    public function login(Request $request)
{
    // Validate đầu vào
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Xác thực người dùng
    if (Auth::attempt($request->only('email', 'password'))) {
        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Kiểm tra vai trò của người dùng
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Điều hướng đến trang quản trị
        } elseif ($user->role === 'customer') {
            return redirect()->route('customer.products'); // Điều hướng đến trang sản phẩm của khách hàng
        }

        // Nếu có các role khác, điều hướng tương ứng
    }

    // Trả về lỗi nếu thông tin đăng nhập không chính xác
    return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
}


    public function logout(Request $request)
    {
        Auth::logout();  // Đăng xuất user
        $request->session()->invalidate();  // Hủy session hiện tại
        $request->session()->regenerateToken();  // Tạo lại CSRF token để tránh CSRF attack

        return redirect()->route('customer.products');  // Chuyển về trang đăng nhập
    }
}
