@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
<style>
    /* Modal backdrop styling - Frosted Glass Effect */
    .modal-backdrop {
        backdrop-filter: blur(12px) saturate(180%);
        -webkit-backdrop-filter: blur(12px) saturate(180%);
        background: rgba(255, 255, 255, 0.15);
        background-image:
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%);
        animation: backdrop-fade-in 0.3s ease-out;
    }

    @keyframes backdrop-fade-in {
        from {
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
            opacity: 0;
        }

        to {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            opacity: 1;
        }
    }

    /* Form styling fixes */
    .btn-primary {
        @apply bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors;
    }

    .btn-outline {
        @apply border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors;
    }

    /* Image preview styling */
    #imagePreview img {
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    /* Price input styling */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Button fixes */
    button {
        cursor: pointer !important;
    }

    button:hover {
        cursor: pointer !important;
    }

    button[onclick] {
        cursor: pointer !important;
        pointer-events: auto !important;
    }

    /* Ensure SVG icons are clickable */
    button svg {
        pointer-events: none;
    }

    /* Enhanced modal styling */
    .modal-content {
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        animation: modal-slide-in 0.3s ease-out;
    }

    @keyframes modal-slide-in {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Hover effects for enhanced interactivity */
    .modal-content:hover {
        box-shadow:
            0 32px 64px -12px rgba(0, 0, 0, 0.35),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: box-shadow 0.3s ease;
    }

    /* Delete modal specific styling */
    .delete-modal-content {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    .delete-warning-box {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid #fca5a5;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1);
        animation: warning-pulse 2s ease-in-out infinite;
    }

    @keyframes warning-pulse {

        0%,
        100% {
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1);
        }

        50% {
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2),
                0 0 20px rgba(239, 68, 68, 0.1);
        }
    }

    /* Red button hover effect */
    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
    }
</style>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản lý sản phẩm</h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý tất cả sản phẩm trong cửa hàng</p>
        </div>
        <button type="button" x-on:click="$dispatch('open-modal')"
            class="mt-4 sm:mt-0 btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Thêm sản phẩm
        </button>

    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tên sản phẩm..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->ma_danhmuc }}" {{ request('category') == $category->ma_danhmuc ? 'selected' : '' }}>
                            {{ $category->ten_danhmuc }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tình trạng kho</label>
                    <select name="stock_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Sắp hết</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
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
                    <a href="{{ route('admin.products.index') }}" class="btn-outline">
                        Xóa lọc
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4">
        <form id="bulkForm" method="POST" action="{{ route('admin.products.bulkAction') }}">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-blue-900" id="selectedCount">0 sản phẩm được chọn</span>

                    <select name="action" required class="px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn thao tác</option>
                        <option value="hide">Ẩn sản phẩm</option>
                        <option value="show">Hiển thị sản phẩm</option>
                        <option value="update_category">Đổi danh mục</option>
                        <option value="delete" class="text-red-600">Xóa sản phẩm</option>
                    </select>

                    <select name="category_id" class="hidden px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->ma_danhmuc }}">{{ $category->ten_danhmuc }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn-primary text-sm">Thực hiện</button>
                    <button type="button" onclick="clearSelection()" class="btn-outline text-sm">Bỏ chọn</button>
                </div>
            </div>
            <input type="hidden" name="products" id="selectedProducts" value="">
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tồn kho</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lượt xem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50" data-product-id="{{ $product->masanpham }}">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $product->masanpham }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-16 h-16 flex-shrink-0">
                                    @if($product->images)
                                    <img src="{{ asset('uploads/' . $product->thumbnail) }}"
                                        alt="{{ $product->tensp }}"
                                        class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $product->tensp }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $product->masanpham }}</div>
                                    @if($product->giam_gia > 0)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        -{{ $product->giam_gia }}%
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $product->category->ten_danhmuc ?? 'Chưa phân loại' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $product->formatted_price }}</div>
                            @if($product->giam_gia > 0)
                            <div class="text-sm text-gray-500 line-through">{{ number_format($product->don_gia) }}đ</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <input type="number"
                                    value="{{ $product->ton_kho }}"
                                    min="0"
                                    onchange="updateStock({{ $product->masanpham }}, this.value)"
                                    class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="text-xs text-gray-500">
                                    @if($product->ton_kho <= 0)
                                        <span class="text-red-600 font-medium">Hết hàng</span>
                                @elseif($product->ton_kho <= 10)
                                    <span class="text-yellow-600 font-medium">Sắp hết</span>
                                    @else
                                    <span class="text-green-600 font-medium">Còn hàng</span>
                                    @endif
                                    </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ number_format($product->luot_xem ?? 0) }}
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" onclick="toggleVisibility({{ $product->masanpham }})"
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full transition-colors cursor-pointer
                                           {{ ($product->hien_thi ?? true) ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                title="Click để thay đổi trạng thái hiển thị">
                                {{ ($product->hien_thi ?? true) ? 'Hiển thị' : 'Ẩn' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button type="button" onclick="viewProduct({{ $product->masanpham }})"
                                    class="p-1 text-blue-600 hover:text-blue-900 hover:bg-blue-100 rounded transition-all cursor-pointer"
                                    title="Xem sản phẩm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="editProduct({{ $product->masanpham }})"
                                    class="p-1 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-100 rounded transition-all cursor-pointer"
                                    title="Chỉnh sửa sản phẩm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteProduct({{ $product->masanpham }}, {{ json_encode($product->tensp) }})"
                                    class="p-1 text-red-600 hover:text-red-900 hover:bg-red-100 rounded transition-all cursor-pointer"
                                    title="Xóa sản phẩm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293L15 18H9l-1.707-1.707A1 1 0 006.586 16H4"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Không có sản phẩm nào</h3>
                                <p class="text-gray-500 mb-4">Chưa có sản phẩm nào được tạo hoặc không có sản phẩm nào phù hợp với bộ lọc.</p>
                                <button type="button" x-on:click="$dispatch('open-modal')" class="btn-primary">
                                    Thêm sản phẩm đầu tiên
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create/Edit Product Modal -->
<div x-data="{ showModal: false }"
    x-show="showModal"
    x-on:open-modal.window="showModal = true"
    x-on:open-edit-modal.window="showModal = true"
    x-on:close-modal.window="showModal = false"
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 z-50"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <!-- Backdrop với hiệu ứng blur -->
    <div class="fixed inset-0 modal-backdrop" x-on:click="showModal = false"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg modal-content max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                x-on:click.stop>
                <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div id="methodField"></div>

                    <div class="bg-white px-6 pt-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Thêm sản phẩm mới</h3>
                            <button type="button" x-on:click="$dispatch('close-modal')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                                    <input type="text" name="tensp" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Nhập tên sản phẩm...">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục *</label>
                                    <select name="ma_danhmuc" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->ma_danhmuc }}">{{ $category->ten_danhmuc }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Giá bán lẻ *</label>
                                        <div class="relative">
                                            <input type="number" name="don_gia" min="0" step="1" required
                                                class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="0">
                                            <span class="absolute right-3 top-2 text-gray-500 text-sm">VND</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Giá sỉ</label>
                                        <div class="relative">
                                            <input type="number" name="wholesale_price" min="0" step="1"
                                                class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="0">
                                            <span class="absolute right-3 top-2 text-gray-500 text-sm">VND</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Giảm giá (%)</label>
                                        <input type="number" name="giam_gia" min="0" max="100" step="1"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Lượt xem</label>
                                        <input type="number" name="so_luot_xem" min="0" value="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
                                    </div>
                                </div>

                                <!-- Product Flags -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-700">Tùy chọn sản phẩm</label>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="promote" value="1"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Khuyến mãi</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="dac_biet" value="1"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Đặc biệt</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Images and Description -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh sản phẩm</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                        <div class="space-y-2">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <label for="images" class="cursor-pointer">
                                                    <span class="mt-2 block text-sm font-medium text-blue-600 hover:text-blue-500">
                                                        Chọn ảnh từ máy tính
                                                    </span>
                                                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 5MB mỗi ảnh</p>
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreviewContainer" class="hidden mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh đã chọn</label>
                                        <div id="imagePreview" class="grid grid-cols-3 gap-4"></div>
                                    </div>

                                    <div id="currentImages" class="hidden mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh hiện tại</label>
                                        <div id="currentImagePreview" class="grid grid-cols-3 gap-4"></div>
                                        <input type="hidden" name="removed_images" id="removedImages">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả ngắn</label>
                                    <textarea name="mo_ta" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Nhập mô tả ngắn về sản phẩm..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Product Information Sections -->
                        <div class="mt-8 space-y-6">
                            <!-- Basic Product Info -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm (Product Name)</label>
                                        <input type="text" name="product_name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Tên sản phẩm chính thức...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nhà sản xuất</label>
                                        <input type="text" name="manufacturer"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Apple, Samsung, OPPO...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Dòng sản phẩm</label>
                                        <input type="text" name="product_line"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="iPhone, Galaxy, Reno...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                                        <input type="text" name="sku"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Mã SKU sản phẩm...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">IMEI/Serial Number</label>
                                        <input type="text" name="imei_serial_number"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="IMEI hoặc Serial Number...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tình trạng</label>
                                        <select name="condition"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Chọn tình trạng</option>
                                            <option value="new">Mới</option>
                                            <option value="like_new">Như mới</option>
                                            <option value="good">Tốt</option>
                                            <option value="fair">Khá</option>
                                            <option value="poor">Kém</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates and Inventory -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Ngày tháng & Tồn kho</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày sản xuất</label>
                                        <input type="date" name="manufacture_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày nhập kho</label>
                                        <input type="date" name="stock_in_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng nhập</label>
                                        <input type="number" name="units_received" min="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tồn kho hiện tại</label>
                                        <input type="number" name="ton_kho" min="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nhà cung cấp</label>
                                        <input type="text" name="supplier"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Tên nhà cung cấp...">
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Specifications -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thông số kỹ thuật</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Màn hình</label>
                                        <input type="text" name="display"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="6.1 inch, OLED, 120Hz...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CPU/Chipset</label>
                                        <input type="text" name="cpu_chipset"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Apple A16, Snapdragon 8 Gen 2...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">RAM</label>
                                        <input type="text" name="ram"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="8GB, 12GB...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bộ nhớ trong</label>
                                        <input type="text" name="internal_storage"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="128GB, 256GB...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hệ điều hành</label>
                                        <input type="text" name="operating_system"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="iOS 16, Android 13...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pin</label>
                                        <input type="text" name="battery"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="4000mAh, 5000mAh...">
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Specifications -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Camera</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Camera sau</label>
                                        <input type="text" name="rear_camera"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="48MP + 12MP + 12MP...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Camera trước</label>
                                        <input type="text" name="front_camera"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="12MP, 32MP...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin camera</label>
                                        <textarea name="camera" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Mô tả chi tiết về camera..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Connectivity & Network -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Kết nối & Mạng</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hỗ trợ SIM</label>
                                        <input type="text" name="sim_support"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="2 Nano SIM, eSIM...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Mạng</label>
                                        <input type="text" name="network"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="5G, 4G LTE...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">WiFi/Bluetooth/NFC</label>
                                        <input type="text" name="wifi_bluetooth_nfc"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="WiFi 6, Bluetooth 5.2, NFC...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Cổng kết nối</label>
                                        <input type="text" name="ports_connector"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="USB-C, Lightning...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin kết nối</label>
                                        <textarea name="connectivity_and_network" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Mô tả chi tiết về kết nối..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Design & Dimensions -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thiết kế & Kích thước</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Kích thước & Trọng lượng</label>
                                        <input type="text" name="dimensions_and_weight"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="147.5 x 71.5 x 7.85mm, 173g...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Chất liệu khung & lưng</label>
                                        <input type="text" name="frame_and_back_materials"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Thép không gỉ, Kính...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Màu sắc</label>
                                        <input type="text" name="colors"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Đen, Trắng, Vàng, Tím...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Chống nước & bụi</label>
                                        <input type="text" name="water_dust_resistance_ip"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="IP68, IP67...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin thiết kế</label>
                                        <textarea name="design_and_dimensions" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Mô tả chi tiết về thiết kế..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Security & Features -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Bảo mật & Tính năng</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bảo mật</label>
                                        <input type="text" name="security"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Face ID, Vân tay, Mật khẩu...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hỗ trợ sạc</label>
                                        <input type="text" name="charging_support"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Sạc nhanh 20W, Sạc không dây...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tính năng đặc biệt</label>
                                        <textarea name="special_features" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Mô tả các tính năng đặc biệt..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Warranty Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Bảo hành</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bảo hành nhà sản xuất</label>
                                        <input type="text" name="manufacturer_warranty"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="12 tháng, 24 tháng...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bảo hành cửa hàng</label>
                                        <input type="text" name="store_warranty"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="6 tháng, 12 tháng...">
                                    </div>
                                </div>
                            </div>

                            <!-- Commercial Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin thương mại</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin thương mại</label>
                                        <textarea name="commercial_information" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Thông tin về giá cả, khuyến mãi..."></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thông tin tồn kho & bán hàng</label>
                                        <textarea name="inventory_and_sales" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Thông tin về tồn kho, doanh số..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Specifications Detail -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thông số kỹ thuật chi tiết</h4>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Thông số kỹ thuật</label>
                                    <textarea name="information" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Mô tả chi tiết tất cả thông số kỹ thuật..."></textarea>
                                </div>
                            </div>

                            <!-- Detailed Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Thông tin chi tiết</h4>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                                    <textarea name="information" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Nhập thông tin chi tiết về sản phẩm..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" x-on:click="$dispatch('close-modal')" class="btn-outline">Hủy</button>
                            <button type="submit" class="btn-primary">Lưu sản phẩm</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div x-data="{ showDeleteModal: false, productToDelete: null, productNameToDelete: '' }"
    x-show="showDeleteModal"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    @keydown.escape="showDeleteModal = false">

    <!-- Modal backdrop -->
    <div class="fixed inset-0 modal-backdrop"
        @click="showDeleteModal = false"></div>

    <!-- Modal content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div x-show="showDeleteModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto modal-content delete-modal-content">

            <!-- Modal header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xóa sản phẩm</h3>
                    </div>
                    <button @click="showDeleteModal = false"
                        type="button"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal body -->
            <div class="p-6">
                <p class="text-gray-600 mb-4">
                    Bạn có chắc chắn muốn xóa sản phẩm này không?
                </p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4 delete-warning-box">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-700 font-medium" x-text="productNameToDelete"></span>
                    </div>
                    <p class="text-sm text-red-600 mt-1">Hành động này không thể hoàn tác!</p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="p-6 border-t border-gray-100 flex space-x-3">
                <button @click="showDeleteModal = false"
                    type="button"
                    class="flex-1 px-4 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hủy
                </button>
                <button @click="confirmDelete()"
                    type="button"
                    class="flex-1 px-4 py-2.5 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium transition-all duration-200 btn-delete">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Xóa sản phẩm
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables
    let selectedProducts = [];
    let removedImages = [];

    // Modal management with Alpine.js events
    window.addEventListener('open-modal', function() {
        const form = document.getElementById('productForm');
        const title = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        // Always reset form when opening modal for new product
        if (form) {
            // Reset form completely
            form.reset();

            // Clear method field (for new product)
            methodField.innerHTML = '';

            // Set title and action for new product
            title.textContent = 'Thêm sản phẩm mới';
            form.action = '{{ route("admin.products.store") }}';

            // Clear all input values manually to ensure complete reset
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"]');
            inputs.forEach(input => {
                input.value = '';
            });

            // Clear all textareas
            const textareas = form.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.value = '';
            });

            // Reset select dropdowns to first option
            const selects = form.querySelectorAll('select');
            selects.forEach(select => {
                if (select.options.length > 0) {
                    select.selectedIndex = 0;
                }
            });

            // Uncheck all checkboxes
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        // Hide current images section
        const currentImages = document.getElementById('currentImages');
        const previewContainer = document.getElementById('imagePreviewContainer');

        if (currentImages) currentImages.classList.add('hidden');
        if (previewContainer) previewContainer.classList.add('hidden');

        removedImages = [];
    });

    // Event for editing product (doesn't reset form)
    window.addEventListener('open-edit-modal', function() {
        // This event is specifically for editing, so we don't reset the form
        // The form will be populated by the editProduct function
    });

    function editProduct(productId) {
        // Show loading notification
        showNotification('info', 'Đang tải dữ liệu sản phẩm...');

        // Fetch product data and populate form
        fetch(`/admin/products/${productId}/edit`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Setup form for editing FIRST
                    document.getElementById('modalTitle').textContent = 'Sửa sản phẩm';

                    // Use standard update route
                    const updateUrl = `/admin/products/${productId}`;
                    document.getElementById('productForm').action = updateUrl;
                    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

                    console.log('Edit setup - Product ID:', productId);
                    console.log('Edit setup - Update URL:', updateUrl);
                    console.log('Form action after setup:', document.getElementById('productForm').action);
                    console.log('Method field after setup:', document.getElementById('methodField').innerHTML);

                    // Show modal AFTER setup using edit-specific event
                    window.dispatchEvent(new CustomEvent('open-edit-modal'));

                    // Force form setup after modal opens
                    setTimeout(() => {
                        document.getElementById('productForm').action = updateUrl;
                        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                        console.log('Form setup after modal open - Action:', document.getElementById('productForm').action);
                        console.log('Form setup after modal open - Method:', document.getElementById('methodField').innerHTML);
                    }, 100);

                    // Test: Check form action after a delay
                    setTimeout(() => {
                        console.log('=== FORM ACTION TEST ===');
                        console.log('Form action after modal open:', document.getElementById('productForm').action);
                        console.log('Method field after modal open:', document.getElementById('methodField').innerHTML);
                        console.log('=== END TEST ===');
                    }, 500);

                    // Populate form fields after a short delay to ensure modal is open
                    setTimeout(() => {
                        try {
                            populateEditForm(data.product, data.categories);
                            showNotification('success', 'Đã tải dữ liệu sản phẩm thành công!');
                        } catch (error) {
                            console.error('Error populating form:', error);
                            showNotification('error', 'Có lỗi khi hiển thị dữ liệu trên form');
                        }
                    }, 300);
                } else {
                    throw new Error(data.message || 'Không thể tải dữ liệu sản phẩm');
                }
            })
            .catch(error => {
                console.error('Error fetching product data:', error);
                showNotification('error', 'Có lỗi xảy ra khi tải dữ liệu sản phẩm: ' + error.message);
            });
    }

    function populateEditForm(product, categories) {
        console.log('Populating form with product:', product);
        const form = document.getElementById('productForm');

        if (!form) {
            console.error('Form not found!');
            return;
        }

        // Clear form first
        form.reset();

        // Debug: List all form elements
        console.log('Form elements:');
        const inputs = form.querySelectorAll('input');
        const textareas = form.querySelectorAll('textarea');
        const selects = form.querySelectorAll('select');

        inputs.forEach(input => console.log(`Input: ${input.name} (${input.type})`));
        textareas.forEach(textarea => console.log(`Textarea: ${textarea.name}`));
        selects.forEach(select => console.log(`Select: ${select.name}`));

        // Populate basic fields with error checking
        const fields = [{
                name: 'tensp',
                value: product.tensp
            },
            {
                name: 'don_gia',
                value: product.don_gia
            },
            {
                name: 'wholesale_price',
                value: product.wholesale_price
            },
            {
                name: 'ton_kho',
                value: product.ton_kho
            },
            {
                name: 'giam_gia',
                value: product.giam_gia ? parseInt(product.giam_gia) : 0
            },
            {
                name: 'so_luot_xem',
                value: product.so_luot_xem
            },
            {
                name: 'product_name',
                value: product.product_name
            },
            {
                name: 'manufacturer',
                value: product.manufacturer
            },
            {
                name: 'product_line',
                value: product.product_line
            },
            {
                name: 'sku',
                value: product.sku
            },
            {
                name: 'imei_serial_number',
                value: product.imei_serial_number
            },
            {
                name: 'manufacture_date',
                value: product.manufacture_date
            },
            {
                name: 'units_received',
                value: product.units_received
            },
            {
                name: 'supplier',
                value: product.supplier
            },
            {
                name: 'display',
                value: product.display
            },
            {
                name: 'cpu_chipset',
                value: product.cpu_chipset
            },
            {
                name: 'ram',
                value: product.ram
            },
            {
                name: 'internal_storage',
                value: product.internal_storage
            },
            {
                name: 'operating_system',
                value: product.operating_system
            },
            {
                name: 'battery',
                value: product.battery
            },
            {
                name: 'rear_camera',
                value: product.rear_camera
            },
            {
                name: 'front_camera',
                value: product.front_camera
            },
            {
                name: 'sim_support',
                value: product.sim_support
            },
            {
                name: 'network',
                value: product.network
            },
            {
                name: 'wifi_bluetooth_nfc',
                value: product.wifi_bluetooth_nfc
            },
            {
                name: 'ports_connector',
                value: product.ports_connector
            },
            {
                name: 'dimensions_and_weight',
                value: product.dimensions_and_weight
            },
            {
                name: 'frame_and_back_materials',
                value: product.frame_and_back_materials
            },
            {
                name: 'colors',
                value: product.colors
            },
            {
                name: 'security',
                value: product.security
            },
            {
                name: 'water_dust_resistance_ip',
                value: product.water_dust_resistance_ip
            },
            {
                name: 'charging_support',
                value: product.charging_support
            },
            {
                name: 'manufacturer_warranty',
                value: product.manufacturer_warranty
            },
            {
                name: 'store_warranty',
                value: product.store_warranty
            }
        ];

        fields.forEach(field => {
            const element = form.querySelector(`input[name="${field.name}"]`);
            if (element) {
                element.value = field.value || '';
                console.log(`Set ${field.name} = ${field.value}`);
            } else {
                console.error(`Field ${field.name} not found`);
            }
        });

        // Populate textareas
        const textareaFields = [{
                name: 'mo_ta',
                value: product.mo_ta
            },
            {
                name: 'information',
                value: product.information
            },
            {
                name: 'camera',
                value: product.camera
            },
            {
                name: 'connectivity_and_network',
                value: product.connectivity_and_network
            },
            {
                name: 'design_and_dimensions',
                value: product.design_and_dimensions
            },
            {
                name: 'special_features',
                value: product.special_features
            },
            {
                name: 'commercial_information',
                value: product.commercial_information
            },
            {
                name: 'inventory_and_sales',
                value: product.inventory_and_sales
            },
            {
                name: 'information',
                value: product.information
            }
        ];

        textareaFields.forEach(field => {
            const element = form.querySelector(`textarea[name="${field.name}"]`);
            if (element) {
                // Strip HTML tags from mo_ta if it contains HTML
                let value = field.value || '';
                if (field.name === 'mo_ta' && value.includes('<')) {
                    value = value.replace(/<[^>]*>/g, '');
                }
                element.value = value;
                console.log(`Set ${field.name} = ${value}`);
            } else {
                console.error(`Textarea ${field.name} not found`);
            }
        });

        // Set category dropdown
        const categorySelect = form.querySelector('select[name="ma_danhmuc"]');
        if (categorySelect) {
            categorySelect.value = product.ma_danhmuc || '';
            console.log(`Set category = ${product.ma_danhmuc}`);
        } else {
            console.error('Category select not found');
        }

        // Set condition dropdown
        const conditionSelect = form.querySelector('select[name="condition"]');
        if (conditionSelect) {
            conditionSelect.value = product.condition || '';
            console.log(`Set condition = ${product.condition}`);
        } else {
            console.error('Condition select not found');
        }

        // Set checkboxes
        const promoteCheckbox = form.querySelector('input[name="promote"]');
        const dacBietCheckbox = form.querySelector('input[name="dac_biet"]');

        if (promoteCheckbox) {
            promoteCheckbox.checked = product.promote == 1;
            console.log(`Set promote = ${product.promote == 1}`);
        }

        if (dacBietCheckbox) {
            dacBietCheckbox.checked = product.dac_biet == 1;
            console.log(`Set dac_biet = ${product.dac_biet == 1}`);
        }

        // Show current images if any
        if (product.images && product.images.length > 0) {
            displayCurrentImages(product.images);
        } else {
            // Hide current images section
            const currentImages = document.getElementById('currentImages');
            if (currentImages) {
                currentImages.classList.add('hidden');
            }
        }

        // Clear new image preview
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        const imageInput = document.getElementById('images');

        if (previewContainer) previewContainer.classList.add('hidden');
        if (preview) preview.innerHTML = '';
        if (imageInput) imageInput.value = '';
    }

    function displayCurrentImages(images) {
        const currentImagesContainer = document.getElementById('currentImages');
        const currentImagePreview = document.getElementById('currentImagePreview');

        if (!currentImagesContainer || !currentImagePreview) return;

        currentImagesContainer.classList.remove('hidden');
        currentImagePreview.innerHTML = '';

        images.forEach((image, index) => {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
            <img src="/uploads/${image}" alt="Current image" class="w-full h-24 object-cover rounded-lg border">
            <button type="button" onclick="removeCurrentImage('${image}', this)"
                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                ×
            </button>
            <div class="absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                ${image.length > 15 ? image.substring(0, 15) + '...' : image}
            </div>
        `;
            currentImagePreview.appendChild(div);
        });
    }

    function removeCurrentImage(imageName, button) {
        // Add to removed images list
        const removedInput = document.getElementById('removedImages');
        const currentRemoved = removedInput.value ? removedInput.value.split(',') : [];
        if (!currentRemoved.includes(imageName)) {
            currentRemoved.push(imageName);
            removedInput.value = currentRemoved.join(',');
        }

        // Remove from display
        button.parentElement.remove();

        // Hide container if no images left
        const currentImagePreview = document.getElementById('currentImagePreview');
        if (currentImagePreview && currentImagePreview.children.length === 0) {
            document.getElementById('currentImages').classList.add('hidden');
        }
    }

    // Image preview function
    function previewImages(input) {
        const container = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            preview.innerHTML = '';

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-lg border">
                        <button type="button" onclick="removeImagePreview(this, ${i})"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                        <div class="absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        } else {
            container.classList.add('hidden');
        }
    }

    function removeImagePreview(button, index) {
        button.parentElement.remove();
        // Reset file input if no images left
        const preview = document.getElementById('imagePreview');
        if (preview.children.length === 0) {
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('images').value = '';
        }
    }

    // CRUD operations
    function viewProduct(productId) {
        console.log('ViewProduct clicked:', productId);
        window.open(`/products/${productId}`, '_blank');
    }

    function deleteProduct(productId, productName) {
        console.log('DeleteProduct clicked:', productId, productName);

        // Set data for delete modal using Alpine.js
        const deleteModal = document.querySelector('[x-data*="showDeleteModal"]');
        if (deleteModal && deleteModal._x_dataStack) {
            deleteModal._x_dataStack[0].productToDelete = productId;
            deleteModal._x_dataStack[0].productNameToDelete = productName;
            deleteModal._x_dataStack[0].showDeleteModal = true;
        }
    }

    function confirmDelete() {
        const deleteModal = document.querySelector('[x-data*="showDeleteModal"]');
        if (deleteModal && deleteModal._x_dataStack) {
            const productId = deleteModal._x_dataStack[0].productToDelete;
            const productName = deleteModal._x_dataStack[0].productNameToDelete;

            if (productId) {
                // Show loading state in modal
                const deleteButton = deleteModal.querySelector('.btn-delete');
                const cancelButton = deleteModal.querySelector('[class*="bg-gray"]');

                if (deleteButton) {
                    deleteButton.disabled = true;
                    deleteButton.innerHTML = `
                        <svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Đang xóa...
                    `;
                    deleteButton.classList.add('opacity-75', 'cursor-not-allowed');
                }

                if (cancelButton) {
                    cancelButton.disabled = true;
                    cancelButton.classList.add('opacity-50', 'cursor-not-allowed');
                }

                // Show loading notification
                showNotification('info', `Đang xóa sản phẩm "${productName}"...`);

                // Send DELETE request via AJAX
                fetch(`/admin/products/${productId}`, {
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
                            // Close modal
                            deleteModal._x_dataStack[0].showDeleteModal = false;

                            // Show success notification
                            showNotification('success', data.message);

                            // Remove product row from table
                            const productRow = document.querySelector(`tr[data-product-id="${productId}"]`);
                            if (productRow) {
                                productRow.style.transition = 'all 0.3s ease';
                                productRow.style.opacity = '0';
                                productRow.style.transform = 'translateX(-20px)';

                                setTimeout(() => {
                                    productRow.remove();
                                    updateProductCount();
                                }, 300);
                            }

                            // Reset button states
                            resetDeleteButtonStates(deleteButton, cancelButton);
                        } else {
                            throw new Error(data.message || 'Có lỗi xảy ra khi xóa sản phẩm');
                        }
                    })
                    .catch(error => {
                        console.error('Delete error:', error);
                        showNotification('error', error.message || 'Có lỗi xảy ra khi xóa sản phẩm');

                        // Reset button states
                        resetDeleteButtonStates(deleteButton, cancelButton);
                    });
            }
        }
    }

    function resetDeleteButtonStates(deleteButton, cancelButton) {
        if (deleteButton) {
            deleteButton.disabled = false;
            deleteButton.innerHTML = `
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Xóa sản phẩm
            `;
            deleteButton.classList.remove('opacity-75', 'cursor-not-allowed');
        }

        if (cancelButton) {
            cancelButton.disabled = false;
            cancelButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function updateProductCount() {
        // Update product count display if exists
        const totalRows = document.querySelectorAll('tbody tr').length;
        const countDisplay = document.querySelector('[data-product-count]');
        if (countDisplay) {
            countDisplay.textContent = totalRows;
        }
    }

    function refreshProductData() {
        // Refresh current page data without full reload
        const currentUrl = new URL(window.location);

        // Add a timestamp to force fresh data
        currentUrl.searchParams.set('_t', Date.now());

        fetch(currentUrl, {
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse response and update table
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableBody = doc.querySelector('tbody');

                if (newTableBody) {
                    const currentTableBody = document.querySelector('tbody');
                    if (currentTableBody) {
                        currentTableBody.innerHTML = newTableBody.innerHTML;
                        updateProductCount();
                        showNotification('info', 'Đã cập nhật danh sách sản phẩm');
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing data:', error);
                showNotification('warning', 'Không thể cập nhật danh sách, vui lòng tải lại trang');
            });
    }

    function updateStock(productId, stock) {
        fetch(`/admin/products/${productId}/stock`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ton_kho: stock
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi cập nhật tồn kho');
            });
    }

    function toggleVisibility(productId) {
        console.log('ToggleVisibility clicked:', productId);
        fetch(`/admin/products/${productId}/visibility`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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

    // Bulk actions
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedProducts();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            updateSelectedProducts();
        }
    });

    function updateSelectedProducts() {
        const checkboxes = document.querySelectorAll('.product-checkbox:checked');
        selectedProducts = Array.from(checkboxes).map(cb => cb.value);

        document.getElementById('selectedCount').textContent = `${selectedProducts.length} sản phẩm được chọn`;
        document.getElementById('selectedProducts').value = selectedProducts.join(',');

        if (selectedProducts.length > 0) {
            document.getElementById('bulkActions').classList.remove('hidden');
        } else {
            document.getElementById('bulkActions').classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateSelectedProducts();
    }

    // Form enhancements
    document.querySelector('select[name="action"]').addEventListener('change', function() {
        const categorySelect = document.querySelector('select[name="category_id"]');
        if (this.value === 'update_category') {
            categorySelect.classList.remove('hidden');
            categorySelect.required = true;
        } else {
            categorySelect.classList.add('hidden');
            categorySelect.required = false;
        }
    });

    // Notifications
    function showNotification(type, message) {
        const notification = document.createElement('div');
        let bgColor = 'bg-red-500 text-white';

        if (type === 'success') {
            bgColor = 'bg-green-500 text-white';
        } else if (type === 'info') {
            bgColor = 'bg-blue-500 text-white';
        } else if (type === 'warning') {
            bgColor = 'bg-yellow-500 text-black';
        }

        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${bgColor}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        // Basic validation
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            showNotification('error', 'Vui lòng điền đầy đủ các trường bắt buộc');
            return;
        }

        // Price validation
        const price = formData.get('don_gia');
        if (!price || parseInt(price) < 1) {
            showNotification('error', 'Giá sản phẩm phải là số và lớn hơn 0');
            return;
        }

        // Discount validation
        const discount = formData.get('giam_gia');
        if (discount && (parseInt(discount) < 0 || parseInt(discount) > 100)) {
            showNotification('error', 'Giảm giá phải là số từ 0 đến 100');
            return;
        }

        // Stock validation
        const stock = formData.get('ton_kho');
        if (!stock || parseInt(stock) < 0) {
            showNotification('error', 'Tồn kho phải là số và lớn hơn hoặc bằng 0');
            return;
        }

        submitButton.textContent = 'Đang lưu...';
        submitButton.disabled = true;

        // For Laravel method spoofing, always use POST method
        const submitMethod = 'POST';

        // Debug: Log form details
        console.log('=== FORM SUBMIT DEBUG ===');
        console.log('Form action:', this.action);
        console.log('Form method field:', document.getElementById('methodField').innerHTML);
        console.log('FormData _method:', formData.get('_method'));
        console.log('Form method:', this.method);
        console.log('Determined method:', submitMethod);
        console.log('=== END DEBUG ===');

        // Debug info
        console.log(`Form will submit to: ${this.action}\nMethod: ${submitMethod}\n_method: ${formData.get('_method')}`);

        // Debug formData contents
        console.log('=== FORMDATA DEBUG ===');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        console.log('=== END FORMDATA DEBUG ===');

        fetch(this.action, {
                method: submitMethod,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                    // Don't set Content-Type - let browser set it for multipart/form-data
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Có lỗi xảy ra');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message || 'Lưu sản phẩm thành công!');

                    // Close modal using Alpine.js
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        bubbles: true
                    }));

                    // Instead of reload, refresh the product row data
                    refreshProductData();
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', error.message || 'Có lỗi xảy ra khi lưu sản phẩm');
            })
            .finally(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
    });

    // Auto-submit filters
    document.querySelectorAll('select[name="category"], select[name="stock_status"]').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Simple price validation - no formatting to avoid conflicts
    document.querySelector('input[name="don_gia"]')?.addEventListener('input', function() {
        // Remove any non-numeric characters except decimal
        this.value = this.value.replace(/[^\d]/g, '');
    });

    document.querySelector('input[name="giam_gia"]')?.addEventListener('input', function() {
        // Remove any non-numeric characters except decimal
        this.value = this.value.replace(/[^\d]/g, '');
        // Ensure max 100
        if (parseInt(this.value) > 100) {
            this.value = '100';
        }
    });
</script>
@endsection
