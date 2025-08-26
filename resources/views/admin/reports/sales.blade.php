@extends('layouts.admin')

@section('title', 'Báo cáo bán hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Báo cáo bán hàng</h1>
            <p class="mt-2 text-sm text-gray-600">Thống kê chi tiết về doanh số và đơn hàng</p>
        </div>

        <!-- Export Button -->
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.reports.export-sales', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Xuất CSV
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Period -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhóm theo</label>
                    <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Ngày</option>
                        <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Tuần</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Tháng</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="w-full btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sales Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tổng đơn hàng</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($salesOverview['total_orders']) }}</p>
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
                    <h3 class="text-sm font-medium text-gray-500">Đơn hoàn thành</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($salesOverview['completed_orders']) }}</p>
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
                    <h3 class="text-sm font-medium text-gray-500">Tổng doanh thu</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($salesOverview['total_revenue']) }}đ</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Giá trị đơn TB</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($salesOverview['avg_order_value'] ?? 0) }}đ</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">SP đã bán</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($salesOverview['total_items_sold']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Doanh số theo thời gian</h3>
        <div class="h-96">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Sales by Payment Method & Status -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Methods -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Theo phương thức thanh toán</h3>
            <div class="space-y-4">
                @forelse($salesByPayment as $payment)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $payment->pttt }}</p>
                        <p class="text-sm text-gray-500">{{ number_format($payment->count) }} đơn hàng</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">{{ number_format($payment->total) }}đ</p>
                        <p class="text-sm text-gray-500">
                            {{ number_format(($payment->total / $salesOverview['total_revenue']) * 100, 1) }}%
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Chưa có dữ liệu</p>
                @endforelse
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Theo trạng thái đơn hàng</h3>
            <div class="space-y-4">
                @forelse($salesByStatus as $status)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">
                            @switch($status->trangthai)
                            @case(1) Chờ xác nhận @break
                            @case(2) Đã xác nhận @break
                            @case(3) Đang giao hàng @break
                            @case(4) Hoàn thành @break
                            @case(5) Giao hàng thất bại @break
                            @case(6) Đã hủy @break
                            @default Không xác định
                            @endswitch
                        </p>
                        <p class="text-sm text-gray-500">{{ number_format($status->count) }} đơn hàng</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">{{ number_format($status->total) }}đ</p>
                        <p class="text-sm text-gray-500">
                            {{ number_format(($status->total / max($salesOverview['total_revenue'], 1)) * 100, 1) }}%
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Chưa có dữ liệu</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Khách hàng VIP</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng đơn</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng chi tiêu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trung bình/đơn</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topCustomers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($customer->hinh_anh)
                                <img src="{{ asset('uploads/avatars/' . $customer->hinh_anh) }}"
                                    alt="{{ $customer->ho_ten }}"
                                    class="w-10 h-10 rounded-full object-cover mr-3">
                                @else
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-gray-500 font-medium">{{ substr($customer->ho_ten, 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->ho_ten }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->sodienthoai }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $customer->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($customer->total_orders) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($customer->total_spent) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($customer->total_spent / max($customer->total_orders, 1)) }}đ
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Chưa có dữ liệu khách hàng
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesByPeriod);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => item.period),
            datasets: [{
                label: 'Doanh thu',
                data: salesData.map(item => item.revenue),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true
            }, {
                label: 'Số đơn hàng',
                data: salesData.map(item => item.orders),
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Số đơn hàng'
                    },
                    grid: {
                        drawOnChartArea: false,
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>
@endsection
