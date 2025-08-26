@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->madonhang)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Chi tiết đơn hàng #{{ $order->madonhang }}</h1>
            <p class="mt-2 text-sm text-gray-600">Thông tin chi tiết về đơn hàng</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.orders.index') }}" class="btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
            <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                In đơn hàng
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Details -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin đơn hàng</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Mã đơn hàng</label>
                        <p class="text-lg font-semibold text-gray-900">#{{ $order->madonhang }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Ngày đặt</label>
                        <p class="text-gray-900">{{ $order->timeorder->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Trạng thái</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_badge_class }}">
                            {{ $order->status_text }}
                        </span>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Thanh toán</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                     {{ $order->thanhtoan ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $order->thanhtoan ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sản phẩm đã đặt</h3>
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->orderDetails as $detail)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ asset('uploads/' . $detail->hinhanh) }}"
                                            alt="{{ $detail->tensp }}"
                                            class="w-12 h-12 rounded-lg object-cover mr-3">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $detail->tensp }}</p>
                                            <p class="text-sm text-gray-500">#{{ $detail->idsanpham }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">{{ number_format($detail->dongia) }}đ</td>
                                <td class="px-4 py-4 text-sm text-gray-900">{{ $detail->soluong }}</td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ number_format($detail->total) }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khách hàng</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Họ tên</label>
                        <p class="text-gray-900">{{ $order->name }}</p>
                    </div>
                    @if($order->email)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $order->email }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm font-medium text-gray-500">Số điện thoại</label>
                        <p class="text-gray-900">{{ $order->dienThoai }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Địa chỉ</label>
                        <p class="text-gray-900">{{ $order->diachi }}</p>
                    </div>
                    @if($order->user)
                    <div class="pt-3 border-t">
                        <a href="{{ route('admin.users.show', $order->user) }}"
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            Xem thông tin tài khoản →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin thanh toán</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phương thức:</span>
                        <span class="font-medium">{{ $order->pttt }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tạm tính:</span>
                        <span>{{ number_format($order->orderDetails->sum('total')) }}đ</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phí vận chuyển:</span>
                        <span>{{ number_format($order->tongdonhang - $order->orderDetails->sum('total')) }}đ</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Tổng cộng:</span>
                            <span class="text-blue-600">{{ number_format($order->tongdonhang) }}đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thao tác</h3>
                <div class="space-y-3">
                    <!-- Update Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cập nhật trạng thái</label>
                        <select onchange="updateOrderStatus({{ $order->id }}, this.value)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="1" {{ $order->trangthai == 1 ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="2" {{ $order->trangthai == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="3" {{ $order->trangthai == 3 ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="4" {{ $order->trangthai == 4 ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="5" {{ $order->trangthai == 5 ? 'selected' : '' }}>Giao hàng thất bại</option>
                            <option value="6" {{ $order->trangthai == 6 ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <!-- Update Payment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái thanh toán</label>
                        <button onclick="togglePaymentStatus({{ $order->id }})"
                            class="w-full px-4 py-2 text-sm font-medium rounded-lg transition-colors
                                       {{ $order->thanhtoan ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                            {{ $order->thanhtoan ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </button>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ghi chú</label>
                        <textarea placeholder="Thêm ghi chú cho đơn hàng..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            rows="3">{{ $order->ghichu ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateOrderStatus(orderId, status) {
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
                    location.reload();
                } else {
                    showNotification('error', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
            });
    }

    function togglePaymentStatus(orderId) {
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
                } else {
                    showNotification('error', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái thanh toán');
            });
    }

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
</script>
@endsection
