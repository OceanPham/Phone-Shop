<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ThePhoneStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Cart functionality -->
    <script src="{{ asset('js/cart.js') }}"></script>

    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Preload styles to prevent FOUC and add custom animations -->
    <style>
        [v-cloak] {
            display: none !important;
        }

        .initial-loading {
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
        }

        .loaded {
            opacity: 1;
        }

        /* Custom animations for smooth experience */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .8;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .animate-pulse-soft {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Smooth transitions for all interactive elements */
        button,
        .btn,
        a[class*="bg-"],
        input[type="submit"] {
            transition: all 0.2s ease-in-out;
        }

        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Loading states */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 initial-loading" id="main-content">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                                ThePhoneStore
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('home') }}" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Trang chủ
                            </a>
                            <a href="{{ route('products.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Sản phẩm
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Search -->
                        <div class="relative">
                            <form action="{{ route('search') }}" method="GET" class="flex">
                                <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-l-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 border border-indigo-600 text-white rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Cart -->
                        <div class="ml-3 relative">
                            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 8H19"></path>
                                </svg>
                                <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </a>
                        </div>

                        <!-- User Menu -->
                        <div class="ml-3 relative">
                            @auth
                            <div class="relative" x-data="{ open: false }">
                                <button type="button"
                                    class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    id="user-menu-button"
                                    @click="open = !open"
                                    @click.away="open = false">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr(auth()->user()->ho_ten, 0, 1) }}</span>
                                    </div>
                                </button>

                                <!-- Dropdown menu -->
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                    style="display: none;">
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                            <div class="font-medium">{{ auth()->user()->ho_ten }}</div>
                                            <div class="text-gray-500">{{ auth()->user()->email }}</div>
                                        </div>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Thông tin cá nhân</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Đơn hàng của tôi</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="flex space-x-2">
                                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 py-2 text-sm font-medium rounded-md hover:bg-indigo-700">Đăng ký</a>
                            </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">ThePhoneStore</h3>
                        <p class="text-gray-300">Chuyên cung cấp điện thoại chính hãng với giá tốt nhất thị trường.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liên kết nhanh</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li><a href="{{ route('home') }}" class="hover:text-white">Trang chủ</a></li>
                            <li><a href="{{ route('products.index') }}" class="hover:text-white">Sản phẩm</a></li>
                            <li><a href="#" class="hover:text-white">Về chúng tôi</a></li>
                            <li><a href="#" class="hover:text-white">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Thông tin</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li><a href="#" class="hover:text-white">Chính sách bảo hành</a></li>
                            <li><a href="#" class="hover:text-white">Chính sách đổi trả</a></li>
                            <li><a href="#" class="hover:text-white">Hướng dẫn mua hàng</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                        <div class="text-gray-300 space-y-2">
                            <p>📍 123 Đường ABC, Quận XYZ, TP.HCM</p>
                            <p>📞 0123 456 789</p>
                            <p>✉️ info@thephonestore.com</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-300">
                    <p>&copy; {{ date('Y') }} ThePhoneStore. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Cart functionality -->
    <script>
        // Update cart count on page load and handle CSS loading
        document.addEventListener('DOMContentLoaded', function() {
            // Remove loading state once DOM is ready
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.classList.remove('initial-loading');
                mainContent.classList.add('loaded');
            }

            updateCartCount();
        });

        function updateCartCount() {
            fetch('/cart/api/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count || 0;
                })
                .catch(error => console.log('Error updating cart count:', error));
        }

        // Add to cart functionality
        function addToCart(productId, quantity = 1) {
            // Create FormData instead of JSON for better Laravel compatibility
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message || 'Có lỗi xảy ra', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message.includes('419')) {
                        showNotification('Phiên làm việc đã hết hạn. Vui lòng tải lại trang.', 'error');
                    } else if (error.message.includes('422')) {
                        showNotification('Dữ liệu không hợp lệ. Vui lòng thử lại.', 'error');
                    } else {
                        showNotification('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng', 'error');
                    }
                });
        }

        function showNotification(message, type) {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-md text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>

</html>
