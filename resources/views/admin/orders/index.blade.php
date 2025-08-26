@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý tất cả đơn hàng trong hệ thống</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tổng đơn hàng</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Chờ xác nhận</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_orders']) }}</p>
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
                    <h3 class="text-sm font-medium text-gray-500">Hoàn thành</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['completed_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Đã hủy</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['cancelled_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Doanh thu</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue']) }}đ</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Hôm nay</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['today_orders']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Mã đơn hàng, tên khách hàng..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Giao hàng thất bại</option>
                        <option value="6" {{ request('status') == '6' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <!-- Payment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thanh toán</label>
                    <select name="payment" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả</option>
                        <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Lọc
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn-outline">Xóa lọc</a>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4">
        <form id="bulkForm" method="POST" action="{{ route('admin.orders.bulkAction') }}">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-blue-900" id="selectedCount">0 đơn hàng được chọn</span>

                    <select name="action" required class="px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn thao tác</option>
                        <option value="update_status">Cập nhật trạng thái</option>
                        <option value="delete" class="text-red-600">Xóa đơn hàng</option>
                    </select>

                    <select name="status" class="hidden px-3 py-1 border border-blue-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Chờ xác nhận</option>
                        <option value="2">Đã xác nhận</option>
                        <option value="3">Đang giao hàng</option>
                        <option value="4">Hoàn thành</option>
                        <option value="5">Giao hàng thất bại</option>
                        <option value="6">Đã hủy</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn-primary text-sm">Thực hiện</button>
                    <button type="button" onclick="clearSelection()" class="btn-outline text-sm">Bỏ chọn</button>
                </div>
            </div>
            <input type="hidden" name="orders" id="selectedOrders" value="">
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thanh toán</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="order-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                value="{{ $order->id }}">
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">#{{ $order->madonhang }}</div>
                                <div class="text-sm text-gray-500">{{ $order->orderDetails->count() }} sản phẩm</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $order->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->dienThoai }}</div>
                                @if($order->email)
                                <div class="text-sm text-gray-500">{{ $order->email }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ number_format($order->tongdonhang) }}đ</div>
                            <div class="text-sm text-gray-500">{{ $order->pttt }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="togglePayment({{ $order->id }})"
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full transition-colors
                                           {{ $order->thanhtoan ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                {{ $order->thanhtoan ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="updateStatus({{ $order->id }}, this.value)"
                                class="text-xs px-2 py-1 rounded-full border-0 focus:ring-2 focus:ring-blue-500 {{ $order->status_badge_class }}">
                                <option value="1" {{ $order->trangthai == 1 ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="2" {{ $order->trangthai == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="3" {{ $order->trangthai == 3 ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="4" {{ $order->trangthai == 4 ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="5" {{ $order->trangthai == 5 ? 'selected' : '' }}>Giao hàng thất bại</option>
                                <option value="6" {{ $order->trangthai == 6 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $order->timeorder->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:text-blue-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.orders.print', $order) }}" target="_blank"
                                    class="text-green-600 hover:text-green-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Không có đơn hàng nào</h3>
                                <p class="text-gray-500">Chưa có đơn hàng nào hoặc không có đơn hàng nào phù hợp với bộ lọc.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Global variables
    let selectedOrders = [];

    // Status update
    function updateStatus(orderId, status) {
        fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    trangthai: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
            });
    }

    // Payment status toggle
    function togglePayment(orderId) {
        const button = event.target;
        const isPaid = button.textContent.includes('Đã thanh toán');

        fetch(`/admin/orders/${orderId}/payment`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    thanhtoan: !isPaid
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                    location.reload();
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái thanh toán');
            });
    }

    // Bulk actions
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.order-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedOrders();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('order-checkbox')) {
            updateSelectedOrders();
        }
    });

    function updateSelectedOrders() {
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        selectedOrders = Array.from(checkboxes).map(cb => cb.value);

        document.getElementById('selectedCount').textContent = `${selectedOrders.length} đơn hàng được chọn`;
        document.getElementById('selectedOrders').value = selectedOrders.join(',');

        if (selectedOrders.length > 0) {
            document.getElementById('bulkActions').classList.remove('hidden');
        } else {
            document.getElementById('bulkActions').classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateSelectedOrders();
    }

    // Form enhancements
    document.querySelector('select[name="action"]').addEventListener('change', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        if (this.value === 'update_status') {
            statusSelect.classList.remove('hidden');
            statusSelect.required = true;
        } else {
            statusSelect.classList.add('hidden');
            statusSelect.required = false;
        }
    });

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

    // Auto-submit filters
    document.querySelectorAll('select[name="status"], select[name="payment"]').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endsection
