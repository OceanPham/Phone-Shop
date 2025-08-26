<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                abort(403, 'Bạn không có quyền truy cập trang này.');
            }
            return $next($request);
        });
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'recent_users' => User::latest()->limit(5)->get(),
            'recent_products' => Product::latest()->limit(5)->get(),
            'low_stock_products' => Product::where('ton_kho', '<', 10)->limit(10)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_nguoidung,email,' . Auth::id(),
            'sodienthoai' => 'required|string|max:20',
            'tai_khoan' => 'nullable|string|max:50|unique:tbl_nguoidung,tai_khoan,' . Auth::id(),
            'diachi' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $data = $request->only(['ho_ten', 'email', 'sodienthoai', 'tai_khoan', 'diachi']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->hinh_anh) {
                $oldAvatarPath = public_path('uploads/avatars/' . $user->hinh_anh);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $avatar = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $filename);
            $data['hinh_anh'] = $filename;
        }

        $user->update($data);

        return redirect()->route('admin.profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (
            !password_verify($request->current_password, $user->mat_khau) &&
            md5($request->current_password) !== $user->mat_khau
        ) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        // Update password
        $user->mat_khau = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Đổi mật khẩu thành công!');
    }
}
