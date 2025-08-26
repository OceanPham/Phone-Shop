<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderDetails.product'])->latest('timeorder');

        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('madonhang', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('dienThoai', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('trangthai', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment')) {
            $query->where('thanhtoan', $request->payment === 'paid');
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('timeorder', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('timeorder', '<=', $request->date_to);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('trangthai', 1)->count(),
            'completed_orders' => Order::where('trangthai', 4)->count(),
            'cancelled_orders' => Order::where('trangthai', 6)->count(),
            'total_revenue' => Order::where('trangthai', 4)->sum('tongdonhang'),
            'today_orders' => Order::whereDate('timeorder', today())->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'trangthai' => 'required|integer|min:1|max:6',
            'note' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->trangthai;
        $order->update([
            'trangthai' => $request->trangthai,
        ]);

        // Log status change if needed
        // You can add order history/log here

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công!',
            'old_status' => $oldStatus,
            'new_status' => $request->trangthai,
        ]);
    }

    /**
     * Update payment status
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'thanhtoan' => 'required|boolean',
        ]);

        $order->update([
            'thanhtoan' => $request->thanhtoan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thanh toán thành công!',
            'payment_status' => $request->thanhtoan,
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:update_status,delete',
            'orders' => 'required|array|min:1',
            'orders.*' => 'exists:tbl_order,id',
            'status' => 'nullable|integer|min:1|max:6',
        ]);

        $orders = Order::whereIn('id', $request->orders);

        switch ($request->action) {
            case 'update_status':
                if (!$request->status) {
                    return back()->withErrors(['status' => 'Vui lòng chọn trạng thái!']);
                }
                $count = $orders->update(['trangthai' => $request->status]);
                $message = "Đã cập nhật trạng thái cho {$count} đơn hàng thành công!";
                break;

            case 'delete':
                $count = $orders->count();
                $orders->delete();
                $message = "Đã xóa {$count} đơn hàng thành công!";
                break;
        }

        return redirect()->route('admin.orders.index')->with('success', $message);
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'today' => [
                'orders' => Order::whereDate('timeorder', today())->count(),
                'revenue' => Order::whereDate('timeorder', today())->where('trangthai', 4)->sum('tongdonhang'),
            ],
            'week' => [
                'orders' => Order::whereBetween('timeorder', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'revenue' => Order::whereBetween('timeorder', [now()->startOfWeek(), now()->endOfWeek()])->where('trangthai', 4)->sum('tongdonhang'),
            ],
            'month' => [
                'orders' => Order::whereMonth('timeorder', now()->month)->count(),
                'revenue' => Order::whereMonth('timeorder', now()->month)->where('trangthai', 4)->sum('tongdonhang'),
            ],
            'status_breakdown' => [
                'pending' => Order::where('trangthai', 1)->count(),
                'confirmed' => Order::where('trangthai', 2)->count(),
                'shipping' => Order::where('trangthai', 3)->count(),
                'completed' => Order::where('trangthai', 4)->count(),
                'failed' => Order::where('trangthai', 5)->count(),
                'cancelled' => Order::where('trangthai', 6)->count(),
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Print order details
     */
    public function print(Order $order)
    {
        $order->load(['user', 'orderDetails.product']);
        return view('admin.orders.print', compact('order'));
    }
}
