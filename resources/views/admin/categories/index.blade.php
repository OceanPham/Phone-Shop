@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản lý danh mục</h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý các danh mục sản phẩm</p>
        </div>
        <button onclick="openCreateModal()"
            class="mt-4 sm:mt-0 btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Thêm danh mục
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="statsContainer">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tổng danh mục</h3>
                    <p class="text-2xl font-bold text-gray-900" id="totalCategories">{{ $categories->total() }}</p>
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
                    <h3 class="text-sm font-medium text-gray-500">Đang hiển thị</h3>
                    <p class="text-2xl font-bold text-gray-900" id="visibleCategories">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Có sản phẩm</h3>
                    <p class="text-2xl font-bold text-gray-900" id="categoriesWithProducts">-</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Danh mục trống</h3>
                    <p class="text-2xl font-bold text-gray-900" id="emptyCategories">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tên danh mục..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="btn-secondary flex-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Tìm kiếm
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-outline">
                        Xóa lọc
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4">
        <form id="bulkForm" method="POST" action="{{ route('admin.categories.bulkAction') }}">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-blue-900" id="selectedCount">0 danh mục được chọn</span>

                    <select name="action" required class="px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn thao tác</option>
                        <option value="hide">Ẩn danh mục</option>
                        <option value="show">Hiển thị danh mục</option>
                        <option value="delete" class="text-red-600">Xóa danh mục</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn-primary text-sm">Thực hiện</button>
                    <button type="button" onclick="clearSelection()" class="btn-outline text-sm">Bỏ chọn</button>
                </div>
            </div>
            <input type="hidden" name="categories" id="selectedCategories" value="">
        </form>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô tả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $category->ma_danhmuc }}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 flex-shrink-0">
                                    @if($category->hinh_anh)
                                    <img src="{{ asset('uploads/categories/' . $category->hinh_anh) }}"
                                        alt="{{ $category->ten_danhmuc }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $category->ten_danhmuc }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $category->ma_danhmuc }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $category->mo_ta ?? 'Chưa có mô tả' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                         {{ $category->products_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $category->products_count }} sản phẩm
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="toggleVisibility({{ $category->ma_danhmuc }})"
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full transition-colors
                                           {{ ($category->hien_thi ?? true) ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                {{ ($category->hien_thi ?? true) ? 'Hiển thị' : 'Ẩn' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $category->created_at ? $category->created_at->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="editCategory({{ $category->ma_danhmuc }})"
                                    class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteCategory({{ $category->ma_danhmuc }}, '{{ $category->ten_danhmuc }}', {{ $category->products_count }})"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Không có danh mục nào</h3>
                                <p class="text-gray-500 mb-4">Chưa có danh mục nào được tạo.</p>
                                <button onclick="openCreateModal()" class="btn-primary">
                                    Thêm danh mục đầu tiên
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="categoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>

                <div class="bg-white px-6 pt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Thêm danh mục mới</h3>
                        <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tên danh mục *</label>
                            <input type="text" name="ten_danhmuc" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                            <textarea name="mo_ta" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh danh mục</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <input type="file" name="image" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-2">Định dạng: JPG, PNG, GIF (tối đa 2MB)</p>
                            </div>
                            <div id="currentImage" class="hidden mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ảnh hiện tại</label>
                                <div id="imagePreview" class="w-20 h-20 rounded-lg overflow-hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeCategoryModal()" class="btn-outline">Hủy</button>
                    <button type="submit" class="btn-primary">Lưu danh mục</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Global variables
    let selectedCategories = [];

    // Load statistics
    function loadStats() {
        fetch('{{ route("admin.categories.stats") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('visibleCategories').textContent = data.visible_categories;
                document.getElementById('categoriesWithProducts').textContent = data.categories_with_products;
                document.getElementById('emptyCategories').textContent = data.empty_categories;
            })
            .catch(error => console.error('Error loading stats:', error));
    }

    // Modal management
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Thêm danh mục mới';
        document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('categoryForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function editCategory(categoryId) {
        fetch(`/admin/categories/${categoryId}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const category = data.category;
                    document.getElementById('modalTitle').textContent = 'Sửa danh mục';
                    document.getElementById('categoryForm').action = `/admin/categories/${categoryId}`;
                    document.getElementById('methodField').innerHTML = '@method("PUT")';

                    // Populate form
                    document.querySelector('input[name="ten_danhmuc"]').value = category.ten_danhmuc;
                    document.querySelector('textarea[name="mo_ta"]').value = category.mo_ta || '';

                    // Show current image if exists
                    if (category.hinh_anh) {
                        document.getElementById('currentImage').classList.remove('hidden');
                        document.getElementById('imagePreview').innerHTML = `
                        <img src="/uploads/categories/${category.hinh_anh}" alt="${category.ten_danhmuc}" class="w-20 h-20 object-cover">
                    `;
                    } else {
                        document.getElementById('currentImage').classList.add('hidden');
                    }

                    document.getElementById('categoryModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Có lỗi xảy ra khi tải thông tin danh mục');
            });
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    // CRUD operations
    function deleteCategory(categoryId, categoryName, productCount) {
        if (productCount > 0) {
            alert(`Không thể xóa danh mục "${categoryName}" vì còn có ${productCount} sản phẩm!`);
            return;
        }

        if (confirm(`Bạn có chắc chắn muốn xóa danh mục "${categoryName}"?`)) {
            fetch(`/admin/categories/${categoryId}`, {
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
                    showNotification('error', 'Có lỗi xảy ra khi xóa danh mục');
                });
        }
    }

    function toggleVisibility(categoryId) {
        fetch(`/admin/categories/${categoryId}/visibility`, {
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

    // Form submission
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
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
                    closeCategoryModal();
                    location.reload();
                } else {
                    showNotification('error', data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Có lỗi xảy ra khi lưu danh mục');
            })
            .finally(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
    });

    // Bulk actions
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedCategories();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('category-checkbox')) {
            updateSelectedCategories();
        }
    });

    function updateSelectedCategories() {
        const checkboxes = document.querySelectorAll('.category-checkbox:checked');
        selectedCategories = Array.from(checkboxes).map(cb => cb.value);

        document.getElementById('selectedCount').textContent = `${selectedCategories.length} danh mục được chọn`;
        document.getElementById('selectedCategories').value = selectedCategories.join(',');

        if (selectedCategories.length > 0) {
            document.getElementById('bulkActions').classList.remove('hidden');
        } else {
            document.getElementById('bulkActions').classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateSelectedCategories();
    }

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

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadStats();
    });
</script>
@endsection
