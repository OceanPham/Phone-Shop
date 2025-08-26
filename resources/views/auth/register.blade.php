@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel - Registration Form -->
    <div class="w-full lg:w-3/5 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-2xl w-full space-y-8 animate-fade-in-up">
            <!-- Logo & Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-green-600 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg transform hover:scale-110 transition-all duration-300">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Tạo tài khoản mới
                </h2>
                <p class="text-gray-600">Tham gia cộng đồng để trải nghiệm những sản phẩm tuyệt vời</p>
            </div>

            <!-- Registration Form -->
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div class="group md:col-span-2">
                        <label for="ho_ten" class="block text-sm font-medium text-gray-700 mb-2">
                            Họ và tên
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="ho_ten" name="ho_ten" type="text" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Nhập họ và tên"
                                value="{{ old('ho_ten') }}">
                        </div>
                        @error('ho_ten')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="group">
                        <label for="tai_khoan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên tài khoản
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2 2 2 0 00-2-2m-2-2H9a2 2 0 00-2 2v0a2 2 0 002 2h2.5M15 7v4.5a2 2 0 002 2h0a2 2 0 002-2V7a2 2 0 00-2-2m-2 0H9a2 2 0 00-2 2v4.5a2 2 0 002 2h2.5"></path>
                                </svg>
                            </div>
                            <input id="tai_khoan" name="tai_khoan" type="text"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Tên tài khoản (tùy chọn)"
                                value="{{ old('tai_khoan') }}">
                        </div>
                        @error('tai_khoan')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="your@email.com"
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="group">
                        <label for="sodienthoai" class="block text-sm font-medium text-gray-700 mb-2">
                            Số điện thoại
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input id="sodienthoai" name="sodienthoai" type="tel" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="0xxx xxx xxx"
                                value="{{ old('sodienthoai') }}">
                        </div>
                        @error('sodienthoai')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="group">
                        <label for="diachi" class="block text-sm font-medium text-gray-700 mb-2">
                            Địa chỉ
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <input id="diachi" name="diachi" type="text"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Địa chỉ (tùy chọn)"
                                value="{{ old('diachi') }}">
                        </div>
                        @error('diachi')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="mat_khau" class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="mat_khau" name="mat_khau" type="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Tối thiểu 8 ký tự">
                        </div>
                        @error('mat_khau')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="group">
                        <label for="mat_khau_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Xác nhận mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input id="mat_khau_confirmation" name="mat_khau_confirmation" type="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Nhập lại mật khẩu">
                        </div>
                        @error('mat_khau_confirmation')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div class="group">
                        <label for="congty" class="block text-sm font-medium text-gray-700 mb-2">
                            Công ty
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <input id="congty" name="congty" type="text"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Tên công ty (tùy chọn)"
                                value="{{ old('congty') }}">
                        </div>
                        @error('congty')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- About Me -->
                    <div class="group">
                        <label for="about_me" class="block text-sm font-medium text-gray-700 mb-2">
                            Giới thiệu bản thân
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                            <input id="about_me" name="about_me" type="text"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Mô tả ngắn về bản thân (tùy chọn)"
                                value="{{ old('about_me') }}">
                        </div>
                        @error('about_me')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-300 group-hover:text-green-200 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                            </svg>
                        </span>
                        Tạo tài khoản
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Đã có tài khoản? </span>
                    <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                        Đăng nhập ngay
                    </a>
                </div>
            </form>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="rounded-xl bg-red-50 p-4 animate-shake">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Vui lòng kiểm tra lại thông tin
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Panel - Hero Image -->
    <div class="hidden lg:flex lg:w-2/5 bg-gradient-to-br from-green-600 via-blue-600 to-purple-800 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0" style="background-image: url('{{ asset('uploads/s23u-1.png') }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>

        <!-- Floating Elements -->
        <div class="absolute top-20 right-10 w-20 h-20 bg-white/10 rounded-full animate-bounce"></div>
        <div class="absolute top-40 left-20 w-16 h-16 bg-white/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 right-20 w-12 h-12 bg-white/15 rounded-full animate-bounce delay-150"></div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
            <div class="animate-fade-in-up delay-300">
                <h1 class="text-4xl font-bold mb-6 bg-gradient-to-r from-white to-green-200 bg-clip-text text-transparent">
                    Trở thành thành viên
                </h1>
                <p class="text-lg mb-8 text-green-100 leading-relaxed text-center">
                    Tham gia cộng đồng để nhận ưu đãi độc quyền và trải nghiệm mua sắm tuyệt vời
                </p>

                <!-- Benefits List -->
                <div class="space-y-4 mt-8">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-green-100">Giảm giá độc quyền cho thành viên</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-green-100">Thông tin sản phẩm mới sớm nhất</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-green-100">Tích điểm và đổi quà hấp dẫn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }

    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-150 {
        animation-delay: 0.15s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }
</style>
@endsection
