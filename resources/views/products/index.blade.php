@extends('layouts.app')

@section('title', 'Tất cả sản phẩm')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tất cả sản phẩm</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><span class="text-gray-500">Sản phẩm</span></li>
                </ol>
            </nav>
        </div>

        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button onclick="toggleMobileFilters()"
                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-50">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    Bộ lọc
                </span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Main Content Layout -->
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filters -->
            <div id="mobileFilters" class="lg:col-span-1 mb-8 lg:mb-0 hidden lg:block">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Bộ lọc
                    </h2>

                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        <!-- Search Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <div class="relative">
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Nhập tên sản phẩm..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        @if(isset($categories) && $categories->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Danh mục</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                    <input type="radio"
                                        name="category"
                                        value="{{ $category->ma_danhmuc }}"
                                        {{ request('category') == $category->ma_danhmuc ? 'checked' : '' }}
                                        class="form-radio text-blue-600 focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-700">{{ $category->ten_danhmuc }}</span>
                                    <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $category->products_count ?? 0 }}</span>
                                </label>
                                @endforeach
                            </div>
                            @if(request('category'))
                            <button type="button" onclick="clearFilter('category')" class="mt-2 text-xs text-blue-600 hover:text-blue-800">
                                Bỏ chọn danh mục
                            </button>
                            @endif
                        </div>
                        @endif

                        <!-- Price Range Filter -->
                        @if(isset($priceRange))
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Khoảng giá</label>
                            <div class="space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number"
                                            name="min_price"
                                            value="{{ request('min_price') }}"
                                            placeholder="Từ"
                                            min="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <input type="number"
                                            name="max_price"
                                            value="{{ request('max_price') }}"
                                            placeholder="Đến"
                                            min="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                </div>

                                <!-- Price Range Shortcuts -->
                                <div class="space-y-1">
                                    <button type="button" onclick="setPriceRange(0, 5000000)" class="w-full text-left text-sm text-gray-600 hover:text-blue-600 py-1">Dưới 5 triệu</button>
                                    <button type="button" onclick="setPriceRange(5000000, 10000000)" class="w-full text-left text-sm text-gray-600 hover:text-blue-600 py-1">5 - 10 triệu</button>
                                    <button type="button" onclick="setPriceRange(10000000, 20000000)" class="w-full text-left text-sm text-gray-600 hover:text-blue-600 py-1">10 - 20 triệu</button>
                                    <button type="button" onclick="setPriceRange(20000000, 50000000)" class="w-full text-left text-sm text-gray-600 hover:text-blue-600 py-1">20 - 50 triệu</button>
                                    <button type="button" onclick="setPriceRange(50000000, null)" class="w-full text-left text-sm text-gray-600 hover:text-blue-600 py-1">Trên 50 triệu</button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Sort Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Sắp xếp theo</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                <option value="sale" {{ request('sort') == 'sale' ? 'selected' : '' }}>Khuyến mãi</option>
                            </select>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex space-x-3">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-300 text-sm">
                                Áp dụng
                            </button>
                            <button type="button" onclick="clearAllFilters()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                Xóa
                            </button>
                        </div>

                        <!-- Active Filters -->
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Bộ lọc hiện tại:</h4>
                            <div class="flex flex-wrap gap-2">
                                @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                    "{{ request('search') }}"
                                    <button type="button" onclick="clearFilter('search')" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                                </span>
                                @endif
                                @if(request('category') && isset($categories))
                                @php $selectedCategory = $categories->where('ma_danhmuc', request('category'))->first(); @endphp
                                @if($selectedCategory)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                    {{ $selectedCategory->ten_danhmuc }}
                                    <button type="button" onclick="clearFilter('category')" class="ml-1 text-green-600 hover:text-green-800">×</button>
                                </span>
                                @endif
                                @endif
                                @if(request('min_price') || request('max_price'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                    {{ request('min_price') ? number_format(request('min_price')) . 'đ' : '0đ' }} - {{ request('max_price') ? number_format(request('max_price')) . 'đ' : '∞' }}
                                    <button type="button" onclick="clearPriceFilter()" class="ml-1 text-yellow-600 hover:text-yellow-800">×</button>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Products Content -->
            <div class="lg:col-span-3">
                <!-- Products Header -->
                @if(isset($products) && $products->count() > 0)
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-gray-600">Hiển thị <span class="font-semibold">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> trong tổng số <span class="font-semibold">{{ $products->total() }}</span> sản phẩm</p>
                        @if(request('search'))
                        <p class="text-sm text-gray-500 mt-1">Kết quả tìm kiếm cho: <strong>"{{ request('search') }}"</strong></p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Products Grid -->
                @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group animate-fade-in-up">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-gray-100">
                            <a href="{{ route('products.show', $product->masanpham) }}">
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
                            </a>

                            <!-- Discount Badge -->
                            @if($product->giam_gia > 0)
                            <div class="absolute top-3 left-3">
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                    -{{ $product->giam_gia }}%
                                </span>
                            </div>
                            @endif

                            <!-- Quick View Button -->
                            <button onclick="quickView({{ $product->masanpham }})"
                                class="absolute top-3 right-3 p-2 bg-white/80 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all duration-200 opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100">
                                <svg class="w-5 h-5 text-gray-600 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>

                            <!-- New Badge -->
                            @if($product->created_at && $product->created_at->diffInDays() <= 7)
                                <div class="absolute bottom-3 left-3">
                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                    MỚI
                                </span>
                        </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="mb-2">
                            @if($product->category)
                            <span class="text-xs text-blue-600 font-medium uppercase tracking-wide hover:text-blue-800 transition-colors">
                                {{ $product->category->ten_danhmuc }}
                            </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                            <a href="{{ route('products.show', $product->masanpham) }}"
                                class="hover:text-blue-600 transition-colors duration-200">
                                {{ $product->tensp }}
                            </a>
                        </h3>

                        @if($product->mo_ta)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {!! Str::limit(strip_tags($product->mo_ta), 80) !!}
                        </p>
                        @endif

                        <!-- Rating -->
                        @if(method_exists($product, 'average_rating') && $product->average_rating > 0)
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    @endfor
                            </div>
                            <span class="text-sm text-gray-500 ml-1">({{ $product->review_count ?? 0 }})</span>
                        </div>
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
                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">
                                Còn {{ $product->ton_kho }}
                            </span>
                            @else
                            <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">
                                Hết hàng
                            </span>
                            @endif
                        </div>

                        <!-- Add to Cart Button -->
                        <button onclick="addToCart({{ $product->masanpham }})"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none {{ $product->ton_kho <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $product->ton_kho <= 0 ? 'disabled' : '' }}>
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5L2 18m8-5v5a2 2 0 002 2h0a2 2 0 002-2v-5"></path>
                                </svg>
                                @if($product->ton_kho <= 0)
                                    Hết hàng
                                    @else
                                    Thêm vào giỏ
                                    @endif
                                    </span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($products, 'links'))
            <div class="mt-12">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="bg-white rounded-xl shadow-lg p-12 max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293L15 18H9l-1.707-1.707A1 1 0 006.586 16H4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Không tìm thấy sản phẩm</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        @if(request('search'))
                        Không có sản phẩm nào phù hợp với từ khóa <strong>"{{ request('search') }}"</strong>.
                        <br>Hãy thử tìm kiếm với từ khóa khác.
                        @elseif(request()->hasAny(['category', 'min_price', 'max_price']))
                        Không có sản phẩm nào phù hợp với bộ lọc hiện tại.
                        <br>Hãy thử điều chỉnh bộ lọc.
                        @else
                        Hiện tại chưa có sản phẩm nào trong cửa hàng.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                        <button onclick="clearAllFilters()" class="btn-secondary">
                            Xóa bộ lọc
                        </button>
                        @endif
                        <a href="{{ route('home') }}" class="btn-primary">
                            Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

<script>
    // Mobile filters toggle
    function toggleMobileFilters() {
        const mobileFilters = document.getElementById('mobileFilters');
        mobileFilters.classList.toggle('hidden');
    }

    // Filter functions
    function clearFilter(filterName) {
        const form = document.getElementById('filterForm');
        const input = form.querySelector(`[name="${filterName}"]`);
        if (input) {
            if (input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
            form.submit();
        }
    }

    function clearPriceFilter() {
        const form = document.getElementById('filterForm');
        const minPrice = form.querySelector('[name="min_price"]');
        const maxPrice = form.querySelector('[name="max_price"]');
        if (minPrice) minPrice.value = '';
        if (maxPrice) maxPrice.value = '';
        form.submit();
    }

    function clearAllFilters() {
        window.location.href = '{{ route("products.index") }}';
    }

    function setPriceRange(min, max) {
        const form = document.getElementById('filterForm');
        const minPrice = form.querySelector('[name="min_price"]');
        const maxPrice = form.querySelector('[name="max_price"]');

        if (minPrice) minPrice.value = min;
        if (maxPrice && max !== null) maxPrice.value = max;
        else if (maxPrice) maxPrice.value = '';

        form.submit();
    }

    // Auto-submit form on select change
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const selectElements = form.querySelectorAll('select');
        const radioElements = form.querySelectorAll('input[type="radio"]');

        selectElements.forEach(select => {
            select.addEventListener('change', function() {
                form.submit();
            });
        });

        radioElements.forEach(radio => {
            radio.addEventListener('change', function() {
                form.submit();
            });
        });

        // Auto-submit on price input with debounce
        const priceInputs = form.querySelectorAll('input[type="number"]');
        let priceTimeout;

        priceInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(priceTimeout);
                priceTimeout = setTimeout(() => {
                    form.submit();
                }, 1000); // Wait 1 second after user stops typing
            });
        });
    });

    // Quick view function
    function quickView(productId) {
        // Placeholder for quick view functionality
        console.log('Quick view for product:', productId);
        // You can implement a modal or redirect to product page
        window.location.href = `/products/${productId}`;
    }

    // Add to cart function
    function addToCart(productId, quantity = 1) {
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;

        button.innerHTML = `
        <span class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Đang thêm...
        </span>
    `;
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
                    button.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Đã thêm!
                </span>
            `;
                    button.classList.remove('from-blue-600', 'to-purple-600');
                    button.classList.add('from-green-500', 'to-green-600');

                    // Update cart count if function exists
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('from-green-500', 'to-green-600');
                        button.classList.add('from-blue-600', 'to-purple-600');
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalContent;
                button.disabled = false;

                // Show error notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
                notification.textContent = error.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng';
                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            });
    }

    // Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = Math.random() * 0.3 + 's';
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.group');
        productCards.forEach(card => {
            observer.observe(card);
        });
    });
</script>

<!-- Add CSS for animations -->
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

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom scrollbar for filter categories */
    .max-h-48::-webkit-scrollbar {
        width: 6px;
    }

    .max-h-48::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .max-h-48::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .max-h-48::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Sticky filter sidebar */
    .sticky {
        position: sticky;
        top: 2rem;
    }

    /* Mobile filter transition */
    #mobileFilters {
        transition: all 0.3s ease-in-out;
    }

    /* Form elements focus styles */
    input:focus,
    select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Button hover effects */
    button:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    button:active:not(:disabled) {
        transform: translateY(0);
    }
</style>
@endsection
