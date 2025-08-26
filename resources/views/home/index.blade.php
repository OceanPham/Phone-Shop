@extends('layouts.app')

@section('title', 'Trang chủ - The Phone Store')

@section('content')
<div class="bg-white">
    <!-- Hero Carousel Section -->
    <div class="relative bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-10 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Hero Carousel -->
        <div class="relative h-screen flex items-center" x-data="heroCarousel()">
            <!-- Carousel Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center w-full">
                <!-- Left Content -->
                <div class="w-full lg:w-1/2 z-10">
                    <div class="space-y-8 animate-fade-in-up">
                        <div>
                            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight">
                                <span class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
                                    The Phone
                                </span>
                                <br>
                                <span class="bg-gradient-to-r from-yellow-400 via-pink-400 to-red-400 bg-clip-text text-transparent">
                                    Store
                                </span>
                            </h1>
                            <p class="mt-6 text-xl text-blue-100 max-w-2xl leading-relaxed">
                                Khám phá bộ sưu tập điện thoại hàng đầu thế giới với công nghệ tiên tiến nhất và giá tốt nhất thị trường.
                            </p>
                        </div>

                        <!-- Call to Action Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('products.index') }}"
                                class="group inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-2xl text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                                <span>Khám phá ngay</span>
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#featured"
                                class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-2xl text-blue-100 border-2 border-blue-200 hover:bg-white/10 transition-all duration-300">
                                Sản phẩm nổi bật
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-8 pt-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white">1000+</div>
                                <div class="text-blue-200 text-sm">Sản phẩm</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white">10k+</div>
                                <div class="text-blue-200 text-sm">Khách hàng</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white">99%</div>
                                <div class="text-blue-200 text-sm">Hài lòng</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Product Showcase -->
                <div class="hidden lg:flex lg:w-1/2 justify-center items-center">
                    <div class="relative">
                        <!-- Main Product Image -->
                        <div class="relative z-10 transform hover:scale-105 transition-all duration-500">
                            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                                <img src="{{ asset('uploads/iphone14prm-2.jpg') }}"
                                    alt="iPhone 14 Pro Max"
                                    class="w-80 h-96 object-cover rounded-2xl">
                                <div class="mt-4 text-center">
                                    <h3 class="text-xl font-bold text-white">iPhone 14 Pro Max</h3>
                                    <p class="text-blue-200">Từ 27.990.000đ</p>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Product Cards -->
                        <div class="absolute -top-10 -left-10 bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-xl animate-float">
                            <img src="{{ asset('uploads/thumb-xiaomi-redmi-10c.jpeg') }}" alt="Samsung" class="w-20 h-24 object-cover rounded-lg">
                            <p class="text-white text-sm mt-2">Xiaomi Redmi 10C</p>
                        </div>

                        <div class="absolute -bottom-10 -right-10 bg-white/20 backdrop-blur-sm rounded-2xl p-4 shadow-xl animate-float delay-1000">
                            <img src="{{ asset('uploads/thumb-xiaomi-13-pro-trang.jpeg') }}" alt="Xiaomi" class="w-20 h-24 object-cover rounded-lg">
                            <p class="text-white text-sm mt-2">Xiaomi 13</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll Down Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Brands Showcase -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Thương hiệu hàng đầu</h2>
                <p class="mt-4 text-lg text-gray-600">Chúng tôi là đại lý chính thức của các thương hiệu lớn</p>
            </div>

            <!-- Brands Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="group flex justify-center p-6 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Apple</div>
                        <p class="text-sm text-gray-500 mt-2">iPhone Series</p>
                    </div>
                </div>
                <div class="group flex justify-center p-6 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Samsung</div>
                        <p class="text-sm text-gray-500 mt-2">Galaxy Series</p>
                    </div>
                </div>
                <div class="group flex justify-center p-6 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Xiaomi</div>
                        <p class="text-sm text-gray-500 mt-2">Mi & Redmi</p>
                    </div>
                </div>
                <div class="group flex justify-center p-6 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">OPPO</div>
                        <p class="text-sm text-gray-500 mt-2">Reno & Find</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="py-20 bg-white" id="categories">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Danh mục sản phẩm
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Khám phá bộ sưu tập đa dạng các dòng điện thoại từ cao cấp đến phổ thông
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($categories as $index => $category)
                <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                    <!-- Category Image -->
                    <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-gray-100 to-gray-200 relative overflow-hidden">
                        @if($category->hinh_anh)
                        <img src="{{ asset('uploads/' . $category->hinh_anh) }}"
                            alt="{{ $category->ten_danhmuc }}"
                            class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Category Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-2">
                            {{ $category->ten_danhmuc }}
                        </h3>
                        @if($category->mo_ta)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($category->mo_ta, 80) }}</p>
                        @endif

                        <a href="{{ route('categories.show', $category->ma_danhmuc) }}"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm group-hover:translate-x-1 transition-transform duration-300">
                            Khám phá ngay
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
    <div class="py-20 bg-gradient-to-br from-gray-50 to-blue-50" id="featured">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Sản phẩm <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">nổi bật</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Những chiếc điện thoại được yêu thích nhất với công nghệ đỉnh cao và thiết kế tuyệt đẹp
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $index => $product)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $index * 150 }}ms">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden bg-gray-100">
                        @if($product->images)
                        <img src="{{ asset('uploads/' . $product->thumbnail) }}"
                            alt="{{ $product->tensp }}"
                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        <!-- Wishlist Button -->
                        <button class="absolute top-3 right-3 p-2 bg-white/80 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-colors duration-200 opacity-0 group-hover:opacity-100">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        @if($product->giam_gia > 0)
                        <!-- Discount Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                -{{ $product->giam_gia }}%
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-2 line-clamp-2">
                            <a href="{{ route('products.show', $product->masanpham) }}">
                                {{ $product->tensp }}
                            </a>
                        </h3>

                        @if($product->mo_ta)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{!! Str::limit(strip_tags($product->mo_ta), 60) !!}</p>
                        @endif

                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex flex-col">
                                @if($product->giam_gia > 0)
                                <span class="text-xl font-bold text-red-600">{{ $product->formatted_price }}</span>
                                <span class="text-sm text-gray-500 line-through">{{ number_format($product->don_gia) }}đ</span>
                                @else
                                <span class="text-xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                @endif
                            </div>

                            <!-- Stock Status -->
                            @if($product->ton_kho > 0)
                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Còn hàng</span>
                            @else
                            <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">Hết hàng</span>
                            @endif
                        </div>

                        <!-- Add to Cart Button -->
                        <button onclick="addToCart({{ $product->masanpham }})"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl {{ $product->ton_kho <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $product->ton_kho <= 0 ? 'disabled' : '' }}>
                            @if($product->ton_kho <= 0)
                                Hết hàng
                                @else
                                Thêm vào giỏ
                                @endif
                                </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-2xl text-blue-600 bg-white border-2 border-blue-200 hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Xem tất cả sản phẩm
                    <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Newsletter Section -->
    <div class="py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full -translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 right-0 w-60 h-60 bg-white/10 rounded-full translate-x-30 translate-y-30"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in-up">
                <h2 class="text-4xl font-bold text-white mb-4">
                    Đăng ký nhận tin khuyến mãi
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Nhận thông tin về sản phẩm mới và các chương trình khuyến mãi hấp dẫn trước tiên
                </p>

                <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <input type="email"
                        placeholder="Nhập email của bạn"
                        class="flex-1 px-6 py-4 rounded-xl border-0 bg-white/20 backdrop-blur-sm text-white placeholder-blue-100 focus:outline-none focus:ring-2 focus:ring-white/50">
                    <button type="submit"
                        class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Đăng ký
                    </button>
                </form>
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

    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    .delay-1000 {
        animation-delay: 1s;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    function heroCarousel() {
        return {
            currentSlide: 0,
            slides: [{
                    title: "iPhone 14 Pro Max",
                    subtitle: "Công nghệ tiên tiến nhất",
                    image: "{{ asset('uploads/iphone14prm-1.jpg') }}"
                },
                {
                    title: "Samsung Galaxy S23",
                    subtitle: "Camera chụp đêm tuyệt vời",
                    image: "{{ asset('uploads/s23u-1.png') }}"
                }
            ],

            init() {
                setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                }, 5000);
            }
        }
    }
</script>
@endsection
