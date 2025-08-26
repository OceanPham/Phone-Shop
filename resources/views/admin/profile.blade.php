@extends('layouts.admin')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Thông tin cá nhân</h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý thông tin tài khoản và bảo mật</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Overview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 mb-4">
                        @if($user->hinh_anh)
                        <img src="{{ asset('uploads/avatars/' . $user->hinh_anh) }}"
                            alt="{{ $user->ho_ten }}"
                            class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-gray-100">
                        @else
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto border-4 border-gray-100">
                            <span class="text-white text-2xl font-bold">{{ substr($user->ho_ten, 0, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->ho_ten }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->role_text }}</p>
                    <div class="mt-4 flex justify-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                     {{ $user->kich_hoat ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="4"></circle>
                            </svg>
                            {{ $user->kich_hoat ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-gray-600">ID: </span>
                            <span class="font-medium ml-1">#{{ $user->id }}</span>
                        </div>
                        @if($user->tai_khoan)
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-gray-600">Username: </span>
                            <span class="font-medium ml-1">{{ $user->tai_khoan }}</span>
                        </div>
                        @endif
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600">Tham gia: </span>
                            <span class="font-medium ml-1">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-600">Cập nhật: </span>
                            <span class="font-medium ml-1">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            @if($user->is_admin)
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Thống kê nhanh</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tổng người dùng</span>
                        <span class="font-semibold">{{ \App\Models\User::count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tổng sản phẩm</span>
                        <span class="font-semibold">{{ \App\Models\Product::count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Đơn hàng hôm nay</span>
                        <span class="font-semibold">{{ \App\Models\Order::whereDate('timeorder', today())->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Doanh thu hôm nay</span>
                        <span class="font-semibold">{{ number_format(\App\Models\Order::whereDate('timeorder', today())->where('trangthai', 4)->sum('tongdonhang')) }}đ</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Profile Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Thông tin cá nhân</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Avatar Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    @if($user->hinh_anh)
                                    <img src="{{ asset('uploads/avatars/' . $user->hinh_anh) }}"
                                        alt="{{ $user->ho_ten }}"
                                        class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center border-2 border-gray-200">
                                        <span class="text-gray-500 font-medium text-lg">{{ substr($user->ho_ten, 0, 1) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="avatar" accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF tối đa 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="ho_ten" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                                <input type="text" name="ho_ten" id="ho_ten" value="{{ old('ho_ten', $user->ho_ten) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('ho_ten')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="sodienthoai" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                <input type="text" name="sodienthoai" id="sodienthoai" value="{{ old('sodienthoai', $user->sodienthoai) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('sodienthoai')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="tai_khoan" class="block text-sm font-medium text-gray-700 mb-2">Tên đăng nhập</label>
                                <input type="text" name="tai_khoan" id="tai_khoan" value="{{ old('tai_khoan', $user->tai_khoan) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('tai_khoan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="diachi" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                            <textarea name="diachi" id="diachi" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('diachi', $user->diachi) }}</textarea>
                            @error('diachi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Cập nhật thông tin
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Đổi mật khẩu</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>

                <form method="POST" action="{{ route('admin.password.change') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại *</label>
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới *</label>
                                <input type="password" name="new_password" id="new_password" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('new_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Tối thiểu 6 ký tự</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới *</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Đổi mật khẩu
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Account Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Cài đặt tài khoản</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>

                <div class="space-y-4">
                    <!-- Account Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Trạng thái tài khoản</h4>
                            <p class="text-sm text-gray-500">Tài khoản của bạn hiện đang {{ $user->kich_hoat ? 'hoạt động' : 'bị khóa' }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                     {{ $user->kich_hoat ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->kich_hoat ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </div>

                    <!-- Role Information -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Vai trò</h4>
                            <p class="text-sm text-gray-500">Quyền hạn của bạn trong hệ thống</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                     {{ $user->vai_tro == 1 ? 'bg-red-100 text-red-800' :
                                        ($user->vai_tro == 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ $user->role_text }}
                        </span>
                    </div>

                    <!-- Security Notice -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-900">Lưu ý bảo mật</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Để bảo vệ tài khoản, hãy sử dụng mật khẩu mạnh và không chia sẻ thông tin đăng nhập với người khác.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="successMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
<script>
    setTimeout(() => {
        document.getElementById('successMessage').style.opacity = '0';
        setTimeout(() => document.getElementById('successMessage').remove(), 300);
    }, 3000);
</script>
@endif

@if($errors->any())
<div id="errorMessage" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>
    setTimeout(() => {
        document.getElementById('errorMessage').style.opacity = '0';
        setTimeout(() => document.getElementById('errorMessage').remove(), 300);
    }, 5000);
</script>
@endif
@endsection
