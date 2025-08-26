@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản lý người dùng</h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý tất cả người dùng trong hệ thống</p>
        </div>
        <button onclick="openCreateModal()"
            class="mt-4 sm:mt-0 btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Thêm người dùng
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tổng người dùng</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Đang hoạt động</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Bị khóa</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['inactive_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Quản trị viên</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['admin_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Khách hàng</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['customer_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Đăng ký hôm nay</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['today_registrations']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tên, email, số điện thoại..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                    <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả vai trò</option>
                        <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Quản trị viên</option>
                        <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Moderator</option>
                        <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>Khách hàng</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Bị khóa</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="btn-secondary flex-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-outline">Xóa lọc</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4">
        <form id="bulkForm" method="POST" action="{{ route('admin.users.bulkAction') }}">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-blue-900" id="selectedCount">0 người dùng được chọn</span>

                    <select name="action" required class="px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn thao tác</option>
                        <option value="activate">Kích hoạt</option>
                        <option value="deactivate">Vô hiệu hóa</option>
                        <option value="change_role">Đổi vai trò</option>
                        <option value="delete" class="text-red-600">Xóa người dùng</option>
                    </select>

                    <select name="role" class="hidden px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn vai trò</option>
                        <option value="1">Quản trị viên</option>
                        <option value="2">Moderator</option>
                        <option value="3">Khách hàng</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn-primary text-sm">Thực hiện</button>
                    <button type="button" onclick="clearSelection()" class="btn-outline text-sm">Bỏ chọn</button>
                </div>
            </div>
            <input type="hidden" name="users" id="selectedUsers" value="">
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người dùng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Liên hệ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vai trò</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tham gia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="user-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $user->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 flex-shrink-0">
                                    @if($user->hinh_anh)
                                    <img src="{{ asset('uploads/avatars/' . $user->hinh_anh) }}"
                                        alt="{{ $user->ho_ten }}"
                                        class="w-12 h-12 rounded-full object-cover">
                                    @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-500 font-medium text-lg">{{ substr($user->ho_ten, 0, 1) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->ho_ten }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                    @if($user->tai_khoan)
                                    <div class="text-sm text-gray-500">@{{ $user->tai_khoan }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500">{{ $user->sodienthoai }}</div>
                                @if($user->diachi)
                                <div class="text-sm text-gray-500 max-w-xs truncate">{{ $user->diachi }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                         {{ $user->vai_tro == 1 ? 'bg-red-100 text-red-800' : ($user->vai_tro == 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ $user->role_text }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $user->id }})"
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full transition-colors
                                           {{ $user->kich_hoat ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                {{ $user->kich_hoat ? 'Hoạt động' : 'Bị khóa' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="viewUser({{ $user->id }})"
                                    class="text-blue-600 hover:text-blue-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="editUser({{ $user->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="resetPassword({{ $user->id }}, '{{ $user->ho_ten }}')"
                                    class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0l1-3m1 3l-1 3M9 7h3m0 0a2 2 0 012 2m0 0a2 2 0 01-2 2m-9 0h3m0 0h3M9 7v3a2 2 0 002 2m1-2V7a2 2 0 012-2"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteUser({{ $user->id }}, '{{ $user->ho_ten }}')"
                                    class="text-red-600 hover:text-red-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Không có người dùng nào</h3>
                                <p class="text-gray-500 mb-4">Chưa có người dùng nào hoặc không có người dùng nào phù hợp với bộ lọc.</p>
                                <button onclick="openCreateModal()" class="btn-primary">
                                    Thêm người dùng đầu tiên
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create/Edit User Modal -->
<div id="userModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="userForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>

                <div class="bg-white px-6 pt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Thêm người dùng mới</h3>
                        <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Họ tên *</label>
                                <input type="text" name="ho_ten" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tài khoản</label>
                                <input type="text" name="tai_khoan"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu *</label>
                            <input type="password" name="mat_khau" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Để trống nếu không muốn thay đổi (khi sửa)</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò *</label>
                                <select name="vai_tro" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Chọn vai trò</option>
                                    <option value="1">Quản trị viên</option>
                                    <option value="2">Moderator</option>
                                    <option value="3">Khách hàng</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                <input type="text" name="sodienthoai" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                            <textarea name="diachi" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeUserModal()" class="btn-outline">Hủy</button>
                    <button type="submit" class="btn-primary">Lưu người dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Global variables
    let selectedUsers = [];

    // Modal management
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Thêm người dùng mới';
        document.getElementById('userForm').action = '{{ route("admin.users.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('userForm').reset();
        document.querySelector('input[name="mat_khau"]').required = true;
        document.getElementById('userModal').classList.remove('hidden');
    }

    function editUser(userId) {
        fetch(`/admin/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    document.getElementById('modalTitle').textContent = 'Sửa người dùng';
                    document.getElementById('userForm').action = `/admin/users/${userId}`;
                    document.getElementById('methodField').innerHTML = '@method("PUT")';

                    // Populate form
                    document.querySelector('input[name="ho_ten"]').value = user.ho_ten;
                    document.querySelector('input[name="tai_khoan"]').value = user.tai_khoan || '';
                    document.querySelector('input[name="email"]').value = user.email;
                    document.querySelector('input[name="mat_khau"]').value = '';
                    document.querySelector('input[name="mat_khau"]').required = false;
                    document.querySelector('select[name="vai_tro"]').value = user.vai_tro;
                    document.querySelector('input[name="sodienthoai"]').value = user.sodienthoai;
                    document.querySelector('textarea[name="diachi"]').value = user.diachi || '';

                    document.getElementById('userModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Có lỗi xảy ra khi tải thông tin người dùng');
            });
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
    }

    // CRUD operations
    function viewUser(userId) {
        window.open(`/admin/users/${userId}`, '_blank');
    }

    function deleteUser(userId, userName) {
        if (confirm(`Bạn có chắc chắn muốn xóa người dùng "${userName}"?`)) {
            fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message);
                        location.reload();
                    } else {
                        showNotification('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Có lỗi xảy ra khi xóa người dùng');
                });
        }
    }

    function toggleStatus(userId) {
        fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                    location.reload();
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi thay đổi trạng thái');
            });
    }

    function resetPassword(userId, userName) {
        const newPassword = prompt(`Nhập mật khẩu mới cho ${userName}:`);
        if (newPassword && newPassword.length >= 6) {
            const confirmPassword = prompt('Xác nhận mật khẩu:');
            if (newPassword === confirmPassword) {
                fetch(`/admin/users/${userId}/reset-password`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            new_password: newPassword,
                            new_password_confirmation: confirmPassword
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('success', data.message);
                        } else {
                            showNotification('error', data.message);
                        }
                    })
                    .catch(error => {
                        showNotification('error', 'Có lỗi xảy ra khi đặt lại mật khẩu');
                    });
            } else {
                alert('Mật khẩu xác nhận không khớp!');
            }
        } else if (newPassword !== null) {
            alert('Mật khẩu phải có ít nhất 6 ký tự!');
        }
    }

    // Form submission
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        submitButton.textContent = 'Đang lưu...';
        submitButton.disabled = true;

        fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                    closeUserModal();
                    location.reload();
                } else {
                    showNotification('error', data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Có lỗi xảy ra khi lưu người dùng');
            })
            .finally(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
    });

    // Bulk actions
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedUsers();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('user-checkbox')) {
            updateSelectedUsers();
        }
    });

    function updateSelectedUsers() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        selectedUsers = Array.from(checkboxes).map(cb => cb.value);

        document.getElementById('selectedCount').textContent = `${selectedUsers.length} người dùng được chọn`;
        document.getElementById('selectedUsers').value = selectedUsers.join(',');

        if (selectedUsers.length > 0) {
            document.getElementById('bulkActions').classList.remove('hidden');
        } else {
            document.getElementById('bulkActions').classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateSelectedUsers();
    }

    // Form enhancements
    document.querySelector('select[name="action"]').addEventListener('change', function() {
        const roleSelect = document.querySelector('select[name="role"]');
        if (this.value === 'change_role') {
            roleSelect.classList.remove('hidden');
            roleSelect.required = true;
        } else {
            roleSelect.classList.add('hidden');
            roleSelect.required = false;
        }
    });

    // Notifications
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Auto-submit filters
    document.querySelectorAll('select[name="role"], select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endsection
