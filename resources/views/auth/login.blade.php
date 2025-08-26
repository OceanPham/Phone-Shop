@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel - Hero Image -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0" style="background-image: url('{{ asset('uploads/iphone14prm-2.jpg') }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-bounce"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-white/20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-40 left-20 w-12 h-12 bg-white/15 rounded-full animate-bounce delay-150"></div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
            <div class="animate-fade-in-up">
                <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                    The Phone Store
                </h1>
                <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                    Khám phá những chiếc điện thoại hàng đầu thế giới với công nghệ tiên tiến nhất
                </p>

                <!-- Product Cards Floating -->
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('uploads/thumb-iphone14prm-1.jpg') }}" alt="iPhone" class="w-full h-24 object-cover rounded-lg mb-2">
                        <p class="text-sm font-semibold">iPhone 14 Pro Max</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 transform hover:scale-105 transition-all duration-300 delay-100">
                        <img src="{{ asset('uploads/thumb-xiaomi-redmi-10c.jpeg') }}" alt="Samsung" class="w-full h-24 object-cover rounded-lg mb-2">
                        <p class="text-sm font-semibold">Xiaomi Redmi 10C</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-md w-full space-y-8 animate-fade-in-up delay-200">
            <!-- Logo & Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg transform hover:scale-110 transition-all duration-300">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Chào mừng trở lại!
                </h2>
                <p class="text-gray-600">Đăng nhập để khám phá các sản phẩm mới nhất</p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Username/Email Field -->
                    <div class="group">
                        <label for="tai_khoan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tài khoản hoặc Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="tai_khoan" name="tai_khoan" type="text" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Nhập tài khoản hoặc email"
                                value="{{ old('tai_khoan') }}">
                        </div>
                        @error('tai_khoan')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="group">
                        <label for="mat_khau" class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="mat_khau" name="mat_khau" type="password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                placeholder="Nhập mật khẩu">
                        </div>
                        @error('mat_khau')
                        <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        Đăng nhập
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Chưa có tài khoản? </span>
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Đăng ký ngay
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
                            Có lỗi xảy ra
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
</style>
@endsection
