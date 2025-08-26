@extends('layouts.app')

@section('title', $product->tensp)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
                <li><span class="text-gray-500">/</span></li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Sản phẩm</a></li>
                @if($product->category)
                <li><span class="text-gray-500">/</span></li>
                <li><a href="{{ route('categories.show', $product->category->ma_danhmuc) }}" class="text-blue-600 hover:text-blue-800">{{ $product->category->ten_danhmuc }}</a></li>
                @endif
                <li><span class="text-gray-500">/</span></li>
                <li><span class="text-gray-500">{{ Str::limit($product->tensp, 50) }}</span></li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                <!-- Product Images -->
                <div class="p-8">
                    <div class="space-y-4">
                        <!-- Main Image -->
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-xl overflow-hidden">
                            @if($product->images)
                            <img id="mainImage"
                                src="{{ asset('uploads/' . $product->images) }}"
                                alt="{{ $product->tensp }}"
                                class="w-full h-96 object-fill hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-96 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Thumbnail Images -->
                        @if($product->images && $product->images_array && is_array($product->images_array) && count($product->images_array) > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($product->images_array as $index => $image)
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all"
                                onclick="changeMainImage('{{ asset('uploads/' . $image) }}')">
                                <img src="{{ asset('uploads/' . $image) }}"
                                    alt="{{ $product->tensp }} {{ $index + 1 }}"
                                    class="w-full h-20 object-cover">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8 lg:p-12">
                    <div class="space-y-6">
                        <!-- Title & Brand -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->tensp }}</h1>
                            @if($product->category)
                            <p class="text-lg text-blue-600 font-medium">{{ $product->category->ten_danhmuc }}</p>
                            @endif
                        </div>

                        <!-- Rating -->
                        @if($reviewCount > 0)
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    @endfor
                            </div>
                            <span class="text-gray-600 text-sm">({{ $reviewCount }} đánh giá)</span>
                        </div>
                        @endif

                        <!-- Price -->
                        <div class="space-y-2">
                            @if($product->giam_gia > 0)
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl font-bold text-red-600">{{ $product->formatted_price }}</span>
                                <span class="text-xl text-gray-500 line-through">{{ number_format($product->don_gia) }}đ</span>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ $product->giam_gia }}%
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">Tiết kiệm: {{ number_format($product->don_gia - $product->discounted_price) }}đ</p>
                            @else
                            <span class="text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="flex items-center space-x-2">
                            @if($product->ton_kho > 0)
                            <span class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Còn hàng ({{ $product->ton_kho }} sản phẩm)
                            </span>
                            @else
                            <span class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10 10.586l1.293-1.293a1 1 0 011.414 1.414L11.414 12l1.293 1.293a1 1 0 01-1.414 1.414L10 13.414l-1.293 1.293a1 1 0 01-1.414-1.414L9.586 12 8.293 10.707a1 1 0 011.414-1.414L10 10.586l1.293-1.293z" clip-rule="evenodd"></path>
                                </svg>
                                Hết hàng
                            </span>
                            @endif
                        </div>

                        <!-- Quantity & Add to Cart -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-700">Số lượng:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button"
                                        onclick="decreaseQuantity()"
                                        class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>

                                    <input type="number"
                                        id="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->ton_kho }}"
                                        class="w-16 text-center border-0 focus:ring-0 focus:outline-none">

                                    <button type="button"
                                        onclick="increaseQuantity()"
                                        class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-4">
                                <button onclick="addToCart({{ $product->masanpham }})"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl {{ $product->ton_kho <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product->ton_kho <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5L2 18m8-5v5a2 2 0 002 2h0a2 2 0 002-2v-5"></path>
                                    </svg>
                                    {{ $product->ton_kho <= 0 ? 'Hết hàng' : 'Thêm vào giỏ hàng' }}
                                </button>

                                <button class="px-6 py-4 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Key Features -->
                        @if($product->information)
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông số kỹ thuật</h3>
                            <div class="text-gray-700 leading-relaxed">
                                {{ $product->information }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'description' }">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 mb-8">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'description'"
                                :class="{ 'border-blue-500 text-blue-600': activeTab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Mô tả sản phẩm
                            </button>
                            <button @click="activeTab = 'reviews'"
                                :class="{ 'border-blue-500 text-blue-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Đánh giá ({{ $reviewCount ?? 0 }})
                            </button>
                            <button @click="activeTab = 'comments'"
                                :class="{ 'border-blue-500 text-blue-600': activeTab === 'comments', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'comments' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Bình luận ({{ $comments ? count($comments) : 0 }})
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="space-y-8">
                        <!-- Description Tab -->
                        <div x-show="activeTab === 'description'" style="display: none;">
                            <div class="prose prose-lg max-w-none">
                                @if($product->mo_ta)
                                {!! $product->mo_ta !!}
                                @else
                                <p class="text-gray-500">Chưa có mô tả cho sản phẩm này.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'" style="display: none;">
                            <div class="space-y-6">
                                @if($reviews && count($reviews) > 0)
                                @foreach($reviews as $review)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">{{ substr($review->user->ho_ten ?? 'A', 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h4 class="font-medium text-gray-900">{{ $review->user->ho_ten ?? 'Ẩn danh' }}</h4>
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= ($review->rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        @endfor
                                                </div>
                                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $review->comment ?? 'Không có bình luận' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-gray-500 text-center py-8">Chưa có đánh giá nào cho sản phẩm này.</p>
                                @endif

                                <!-- Add Review Form -->
                                @auth
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h4 class="font-semibold text-gray-900 mb-4">Viết đánh giá</h4>
                                    <form action="{{ route('products.reviews.store', $product->masanpham) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá</label>
                                                <div class="flex items-center space-x-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" onclick="setRating({{ $i }})" class="rating-star text-gray-300 hover:text-yellow-400 focus:outline-none">
                                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        </button>
                                                        @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="rating" value="5">
                                            </div>
                                            <div>
                                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Bình luận</label>
                                                <textarea name="comment" id="comment" rows="4" required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                                            </div>
                                            <button type="submit" class="btn-primary">Gửi đánh giá</button>
                                        </div>
                                    </form>
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">Đăng nhập để viết đánh giá</p>
                                    <a href="{{ route('login') }}" class="btn-primary">Đăng nhập</a>
                                </div>
                                @endauth
                            </div>
                        </div>

                        <!-- Comments Tab -->
                        <div x-show="activeTab === 'comments'" style="display: none;">
                            <div class="space-y-6">
                                @if($comments && count($comments) > 0)
                                @foreach($comments as $comment)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-medium text-sm">{{ substr($comment->user->ho_ten ?? 'A', 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h4 class="font-medium text-gray-900">{{ $comment->user->ho_ten ?? 'Ẩn danh' }}</h4>
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $comment->comment ?? 'Không có nội dung' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-gray-500 text-center py-8">Chưa có bình luận nào cho sản phẩm này.</p>
                                @endif

                                <!-- Add Comment Form -->
                                @auth
                                <div class="bg-white border border-gray-200 rounded-lg p-6">
                                    <h4 class="font-semibold text-gray-900 mb-4">Viết bình luận</h4>
                                    <form action="{{ route('products.comments.store', $product->masanpham) }}" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label for="comment_text" class="block text-sm font-medium text-gray-700 mb-2">Bình luận</label>
                                                <textarea name="comment" id="comment_text" rows="4" required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Viết bình luận của bạn..."></textarea>
                                            </div>
                                            <button type="submit" class="btn-primary">Gửi bình luận</button>
                                        </div>
                                    </form>
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">Đăng nhập để viết bình luận</p>
                                    <a href="{{ route('login') }}" class="btn-primary">Đăng nhập</a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                        @if($related->images)
                        <img src="{{ asset('uploads/' . $related->thumbnail) }}"
                            alt="{{ $related->tensp }}"
                            class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        @if($related->giam_gia > 0)
                        <div class="absolute top-2 left-2">
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                -{{ $related->giam_gia }}%
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('products.show', $related->masanpham) }}" class="hover:text-blue-600">
                                {{ $related->tensp }}
                            </a>
                        </h3>

                        <div class="flex items-center justify-between">
                            <div>
                                @if($related->giam_gia > 0)
                                <span class="text-lg font-bold text-red-600">{{ $related->formatted_price }}</span>
                                <span class="text-sm text-gray-500 line-through block">{{ number_format($related->don_gia) }}đ</span>
                                @else
                                <span class="text-lg font-bold text-gray-900">{{ $related->formatted_price }}</span>
                                @endif
                            </div>

                            <button onclick="addToCart({{ $related->masanpham }})"
                                class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                Thêm
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Quantity controls
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

    // Image gallery
    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) {
            mainImage.src = src;
        }
    }

    // Rating system
    function setRating(rating) {
        const ratingInput = document.getElementById('rating');
        if (ratingInput) {
            ratingInput.value = rating;
        }

        const stars = document.querySelectorAll('.rating-star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    // Add to cart with quantity
    function addToCart(productId) {
        const quantityInput = document.getElementById('quantity');
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
        const button = event.target;
        const originalText = button.textContent;

        button.textContent = 'Đang thêm...';
        button.disabled = true;

        fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.textContent = 'Đã thêm!';
                    button.classList.add('bg-green-600');
                    updateCartCount();

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('bg-green-600');
                        button.disabled = false;
                    }, 2000);
                } else {
                    alert(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
                    button.textContent = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
                button.textContent = originalText;
                button.disabled = false;
            });
    }
</script>
@endsection
