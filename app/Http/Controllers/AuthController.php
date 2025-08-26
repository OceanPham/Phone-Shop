<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tai_khoan' => 'required|string',
            'mat_khau' => 'required|string',
        ], [
            'tai_khoan.required' => 'Vui lòng nhập tài khoản',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find user by tai_khoan
        $user = User::where('tai_khoan', $request->tai_khoan)
            ->where('kich_hoat', 1)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'tai_khoan' => 'Tài khoản không tồn tại hoặc đã bị khóa'
            ])->withInput();
        }

        // Check password - handle both legacy MD5 and Laravel hash
        $isPasswordCorrect = false;

        // Check MD5 first (legacy system)
        if (md5($request->mat_khau) === $user->mat_khau) {
            // Legacy MD5 hash - update to Laravel hash for security
            $user->mat_khau = Hash::make($request->mat_khau);
            $user->save();
            $isPasswordCorrect = true;
        } elseif (strlen($user->mat_khau) > 32 && Hash::check($request->mat_khau, $user->mat_khau)) {
            // Laravel bcrypt hash (length > 32 chars)
            $isPasswordCorrect = true;
        }

        if (!$isPasswordCorrect) {
            return back()->withErrors([
                'mat_khau' => 'Mật khẩu không chính xác'
            ])->withInput();
        }

        // Login user
        Auth::login($user, $request->has('remember'));

        // Redirect based on role
        if ($user->is_admin) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tai_khoan' => 'required|string|min:3|max:50|unique:tbl_nguoidung,tai_khoan',
            'mat_khau' => 'required|string|min:6|confirmed',
            'ho_ten' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:tbl_nguoidung,email',
            'sodienthoai' => 'required|string|max:11',
        ], [
            'tai_khoan.required' => 'Vui lòng nhập tài khoản',
            'tai_khoan.unique' => 'Tài khoản đã tồn tại',
            'tai_khoan.min' => 'Tài khoản phải có ít nhất 3 ký tự',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu',
            'mat_khau.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'mat_khau.confirmed' => 'Xác nhận mật khẩu không khớp',
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'tai_khoan' => $request->tai_khoan,
                'mat_khau' => Hash::make($request->mat_khau),
                'ho_ten' => $request->ho_ten,
                'email' => $request->email,
                'sodienthoai' => $request->sodienthoai,
                'diachi' => $request->diachi,
                'vai_tro' => 3, // Customer role
                'kich_hoat' => 1,
                'shipping_id' => 0,
                'default_payment' => 'codpayment',
            ]);

            // Auto login after registration
            Auth::login($user);

            return redirect('/')->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.'
            ])->withInput();
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
