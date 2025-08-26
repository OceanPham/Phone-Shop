<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ho_ten', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('tai_khoan', 'like', '%' . $request->search . '%')
                    ->orWhere('sodienthoai', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('vai_tro', $request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('kich_hoat', $request->status);
        }

        $users = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('kich_hoat', 1)->count(),
            'inactive_users' => User::where('kich_hoat', 0)->count(),
            'admin_users' => User::where('vai_tro', 1)->count(),
            'customer_users' => User::where('vai_tro', 3)->count(),
            'today_registrations' => User::whereDate('created_at', today())->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:50',
            'email' => 'required|email|unique:tbl_nguoidung,email',
            'tai_khoan' => 'nullable|string|max:50|unique:tbl_nguoidung,tai_khoan',
            'mat_khau' => 'required|min:6',
            'vai_tro' => 'required|integer|in:1,2,3',
            'sodienthoai' => 'required|string|max:11',
            'diachi' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['ho_ten', 'email', 'tai_khoan', 'vai_tro', 'sodienthoai', 'diachi']);
        $data['mat_khau'] = Hash::make($request->mat_khau);
        $data['kich_hoat'] = 1;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $filename);
            $data['hinh_anh'] = $filename;
        }

        User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Người dùng đã được tạo thành công!'
        ]);
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['orders' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:50',
            'email' => 'required|email|unique:tbl_nguoidung,email,' . $user->id,
            'tai_khoan' => 'nullable|string|max:50|unique:tbl_nguoidung,tai_khoan,' . $user->id,
            'mat_khau' => 'nullable|min:6',
            'vai_tro' => 'required|integer|in:1,2,3',
            'sodienthoai' => 'required|string|max:11',
            'diachi' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['ho_ten', 'email', 'tai_khoan', 'vai_tro', 'sodienthoai', 'diachi']);

        // Update password if provided
        if ($request->filled('mat_khau')) {
            $data['mat_khau'] = Hash::make($request->mat_khau);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Người dùng đã được cập nhật thành công!'
        ]);
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa người dùng này vì còn có đơn hàng!'
            ], 422);
        }

        // Delete user avatar
        if ($user->hinh_anh) {
            $avatarPath = public_path('uploads/avatars/' . $user->hinh_anh);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Người dùng đã được xóa thành công!'
        ]);
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'kich_hoat' => !$user->kich_hoat,
        ]);

        return response()->json([
            'success' => true,
            'message' => $user->kich_hoat ? 'Đã kích hoạt người dùng' : 'Đã vô hiệu hóa người dùng',
            'status' => $user->kich_hoat,
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete,change_role',
            'users' => 'required|array|min:1',
            'users.*' => 'exists:tbl_nguoidung,id',
            'role' => 'nullable|integer|in:1,2,3',
        ]);

        $users = User::whereIn('id', $request->users);

        switch ($request->action) {
            case 'activate':
                $count = $users->update(['kich_hoat' => 1]);
                $message = "Đã kích hoạt {$count} người dùng thành công!";
                break;

            case 'deactivate':
                $count = $users->update(['kich_hoat' => 0]);
                $message = "Đã vô hiệu hóa {$count} người dùng thành công!";
                break;

            case 'change_role':
                if (!$request->role) {
                    return back()->withErrors(['role' => 'Vui lòng chọn vai trò!']);
                }
                $count = $users->update(['vai_tro' => $request->role]);
                $message = "Đã cập nhật vai trò cho {$count} người dùng thành công!";
                break;

            case 'delete':
                // Check if any user has orders
                $usersWithOrders = $users->withCount('orders')->get()->filter(function ($user) {
                    return $user->orders_count > 0;
                });

                if ($usersWithOrders->count() > 0) {
                    return back()->withErrors([
                        'bulk' => 'Không thể xóa ' . $usersWithOrders->count() . ' người dùng vì còn có đơn hàng!'
                    ]);
                }

                // Delete avatars
                foreach ($users->get() as $user) {
                    if ($user->hinh_anh) {
                        $avatarPath = public_path('uploads/avatars/' . $user->hinh_anh);
                        if (file_exists($avatarPath)) {
                            unlink($avatarPath);
                        }
                    }
                }

                $count = $users->count();
                $users->delete();
                $message = "Đã xóa {$count} người dùng thành công!";
                break;
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user->update([
            'mat_khau' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt lại mật khẩu thành công!'
        ]);
    }
}
