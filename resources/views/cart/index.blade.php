@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Giỏ hàng của bạn</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><span class="text-gray-500">Giỏ hàng</span></li>
                </ol>
            </nav>
        </div>

        @if(session('warning'))
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(!empty($cartItems))
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Sản phẩm ({{ count($cartItems) }})</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200" data-product-id="{{ $item['product']->masanpham }}">
                            <div class="flex items-center space-x-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 w-20 h-20">
                                    @if($item['product']->images)
                                    <img src="{{ asset('uploads/' . $item['product']->thumbnail) }}" 
                                         alt="{{ $item['product']->tensp }}" 
                                         class="w-full h-full object-cover rounded-lg shadow-sm">
                                    @else
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                                        <a href="{{ route('products.show', $item['product']->masanpham) }}" 
                                           class="hover:text-blue-600 transition-colors">
                                            {{ $item['product']->tensp }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Price -->
                                    <div class="flex items-center space-x-2 mb-2">
                                        @if($item['product']->giam_gia > 0)
                                        <span class="text-lg font-bold text-red-600">{{ $item['product']->formatted_price }}</span>
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($item['product']->don_gia) }}đ</span>
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">-{{ $item['product']->giam_gia }}%</span>
                                        @else
                                        <span class="text-lg font-bold text-gray-900">{{ $item['product']->formatted_price }}</span>
                                        @endif
                                    </div>

                                    <!-- Stock Status -->
                                    @if($item['product']->ton_kho <= 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Hết hàng
                                    </span>
                                    @elseif($item['product']->ton_kho < 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Chỉ còn {{ $item['product']->ton_kho }} sản phẩm
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Còn hàng
                                    </span>
                                    @endif
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-3">
                                    <label class="sr-only">Số lượng</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item['product']->masanpham }}, {{ $item['quantity'] - 1 }})"
                                                class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        
                                        <input type="number" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1" 
                                               max="{{ $item['product']->ton_kho }}"
                                               class="w-16 text-center border-0 focus:ring-0 focus:outline-none"
                                               onchange="updateQuantity({{ $item['product']->masanpham }}, this.value)">
                                        
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item['product']->masanpham }}, {{ $item['quantity'] + 1 }})"
                                                class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors"
                                                {{ $item['quantity'] >= $item['product']->ton_kho ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal & Remove -->
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900 mb-2">
                                        {{ number_format($item['subtotal']) }}đ
                                    </div>
                                    <button type="button" 
                                            onclick="removeFromCart({{ $item['product']->masanpham }})"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors">
                                        Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continue Shopping -->
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính ({{ count($cartItems) }} sản phẩm)</span>
                            <span class="font-medium">{{ number_format($cartSummary['subtotal']) }}đ</span>
                        </div>
                        
                        @if($cartSummary['discount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Giảm giá</span>
                            <span>-{{ number_format($cartSummary['discount']) }}đ</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển</span>
                            <span class="font-medium">{{ number_format($cartSummary['shipping']) }}đ</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Tổng cộng</span>
                                <span class="text-blue-600">{{ number_format($cartSummary['total']) }}đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button onclick="proceedToCheckout()" 
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Tiến hành thanh toán
                    </button>

                    <!-- Clear Cart -->
                    <button onclick="clearCart()" 
                            class="w-full mt-3 text-gray-600 hover:text-gray-800 font-medium py-2 transition-colors">
                        Xóa toàn bộ giỏ hàng
                    </button>

                    <!-- Security Info -->
                    <div class="mt-6 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Thanh toán an toàn & bảo mật</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-12">
            <div class="bg-white rounded-xl shadow-lg p-12 max-w-md mx-auto">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Giỏ hàng trống</h2>
                <p class="text-gray-600 mb-8">Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Bắt đầu mua sắm
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Update quantity function
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch(`/cart/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update cart display
        } else {
            alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
    });
}

// Remove from cart function
function removeFromCart(productId) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        return;
    }
    
    fetch(`/cart/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update cart display
            updateCartCount(); // Update cart count in header
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa sản phẩm');
    });
}

// Clear entire cart
function clearCart() {
    if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
        return;
    }
    
    fetch('/cart', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update cart display
            updateCartCount(); // Update cart count in header
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa giỏ hàng');
    });
}

// Proceed to checkout
function proceedToCheckout() {
    // TODO: Implement checkout flow
    alert('Chức năng thanh toán đang được phát triển!');
}

// Add to cart function (for use in other pages)
function addToCart(productId, quantity = 1) {
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
