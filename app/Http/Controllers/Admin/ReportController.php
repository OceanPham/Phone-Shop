<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display main reports dashboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // Default last 30 days
        $startDate = Carbon::now()->subDays($period);
        $endDate = Carbon::now();

        // Overview statistics
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('trangthai', 4)->sum('tongdonhang'),
            'total_products' => Product::count(),
            'total_customers' => User::where('vai_tro', 3)->count(),
            'pending_orders' => Order::where('trangthai', 1)->count(),
            'completed_orders' => Order::where('trangthai', 4)->count(),
            'low_stock_products' => Product::where('ton_kho', '<=', 10)->count(),
            'out_of_stock_products' => Product::where('ton_kho', 0)->count(),
        ];

        // Period statistics
        $periodStats = [
            'orders' => Order::whereBetween('timeorder', [$startDate, $endDate])->count(),
            'revenue' => Order::whereBetween('timeorder', [$startDate, $endDate])
                ->where('trangthai', 4)
                ->sum('tongdonhang'),
            'new_customers' => User::whereBetween('created_at', [$startDate, $endDate])
                ->where('vai_tro', 3)
                ->count(),
            'avg_order_value' => Order::whereBetween('timeorder', [$startDate, $endDate])
                ->where('trangthai', 4)
                ->avg('tongdonhang'),
        ];

        // Daily sales chart data (last 30 days)
        $dailySales = Order::select(
            DB::raw('DATE(timeorder) as date'),
            DB::raw('COUNT(*) as orders'),
            DB::raw('SUM(CASE WHEN trangthai = 4 THEN tongdonhang ELSE 0 END) as revenue')
        )
            ->whereBetween('timeorder', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy(DB::raw('DATE(timeorder)'))
            ->orderBy('date')
            ->get();

        // Top selling categories
        $topCategories = Category::select('tbl_danhmuc.*')
            ->withCount(['products as total_sold' => function ($query) {
                $query->join('tbl_order_detail', 'tbl_sanpham.masanpham', '=', 'tbl_order_detail.idsanpham')
                    ->join('tbl_order', 'tbl_order_detail.iddonhang', '=', 'tbl_order.id')
                    ->where('tbl_order.trangthai', 4);
            }])
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Recent orders
        $recentOrders = Order::with(['user'])
            ->latest('timeorder')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'periodStats',
            'dailySales',
            'topCategories',
            'recentOrders',
            'period'
        ));
    }

    /**
     * Sales reports
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $period = $request->get('period', 'daily'); // daily, weekly, monthly

        // Sales overview
        $salesOverview = [
            'total_orders' => Order::whereBetween('timeorder', [$startDate, $endDate])->count(),
            'completed_orders' => Order::whereBetween('timeorder', [$startDate, $endDate])
                ->where('trangthai', 4)
                ->count(),
            'total_revenue' => Order::whereBetween('timeorder', [$startDate, $endDate])
                ->where('trangthai', 4)
                ->sum('tongdonhang'),
            'avg_order_value' => Order::whereBetween('timeorder', [$startDate, $endDate])
                ->where('trangthai', 4)
                ->avg('tongdonhang'),
            'total_items_sold' => DB::table('tbl_order_detail')
                ->join('tbl_order', 'tbl_order_detail.iddonhang', '=', 'tbl_order.id')
                ->whereBetween('tbl_order.timeorder', [$startDate, $endDate])
                ->where('tbl_order.trangthai', 4)
                ->sum('tbl_order_detail.soluong'),
        ];

        // Sales by period
        $salesByPeriod = $this->getSalesByPeriod($startDate, $endDate, $period);

        // Sales by payment method
        $salesByPayment = Order::select('pttt', DB::raw('COUNT(*) as count'), DB::raw('SUM(tongdonhang) as total'))
            ->whereBetween('timeorder', [$startDate, $endDate])
            ->where('trangthai', 4)
            ->groupBy('pttt')
            ->get();

        // Sales by status
        $salesByStatus = Order::select('trangthai', DB::raw('COUNT(*) as count'), DB::raw('SUM(tongdonhang) as total'))
            ->whereBetween('timeorder', [$startDate, $endDate])
            ->groupBy('trangthai')
            ->get();

        // Top customers
        $topCustomers = User::select('tbl_nguoidung.*')
            ->withCount(['orders as total_orders' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('timeorder', [$startDate, $endDate])
                    ->where('trangthai', 4);
            }])
            ->withSum(['orders as total_spent' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('timeorder', [$startDate, $endDate])
                    ->where('trangthai', 4);
            }], 'tongdonhang')
            ->having('total_orders', '>', 0)
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.sales', compact(
            'salesOverview',
            'salesByPeriod',
            'salesByPayment',
            'salesByStatus',
            'topCustomers',
            'startDate',
            'endDate',
            'period'
        ));
    }

    /**
     * Product reports
     */
    public function products(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Product overview
        $productOverview = [
            'total_products' => Product::count(),
            'in_stock_products' => Product::where('ton_kho', '>', 0)->count(),
            'out_of_stock_products' => Product::where('ton_kho', 0)->count(),
            'low_stock_products' => Product::where('ton_kho', '<=', 10)->where('ton_kho', '>', 0)->count(),
            'avg_stock_value' => Product::avg(DB::raw('ton_kho * don_gia')),
            'total_stock_value' => Product::sum(DB::raw('ton_kho * don_gia')),
        ];

        // Best selling products
        $bestSellingProducts = Product::select('tbl_sanpham.*')
            ->withSum(['orderDetails as total_sold' => function ($query) use ($startDate, $endDate) {
                $query->join('tbl_order', 'tbl_order_detail.iddonhang', '=', 'tbl_order.id')
                    ->whereBetween('tbl_order.timeorder', [$startDate, $endDate])
                    ->where('tbl_order.trangthai', 4);
            }], 'soluong')
            ->withSum(['orderDetails as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->join('tbl_order', 'tbl_order_detail.iddonhang', '=', 'tbl_order.id')
                    ->whereBetween('tbl_order.timeorder', [$startDate, $endDate])
                    ->where('tbl_order.trangthai', 4);
            }], DB::raw('soluong * dongia'))
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->where('ton_kho', '<=', 10)
            ->orderBy('ton_kho', 'asc')
            ->limit(20)
            ->get();

        // Products by category
        $productsByCategory = Category::withCount('products')
            ->withSum(['products as total_stock_value'], DB::raw('ton_kho * don_gia'))
            ->orderBy('products_count', 'desc')
            ->get();

        // Most viewed products
        $mostViewedProducts = Product::with('category')
            ->orderBy('so_luot_xem', 'desc')
            ->limit(20)
            ->get();

        // Products with no sales
        $noSalesProducts = Product::with('category')
            ->whereDoesntHave('orderDetails', function ($query) use ($startDate, $endDate) {
                $query->join('tbl_order', 'tbl_order_detail.iddonhang', '=', 'tbl_order.id')
                    ->whereBetween('tbl_order.timeorder', [$startDate, $endDate])
                    ->where('tbl_order.trangthai', 4);
            })
            ->limit(20)
            ->get();

        return view('admin.reports.products', compact(
            'productOverview',
            'bestSellingProducts',
            'lowStockProducts',
            'productsByCategory',
            'mostViewedProducts',
            'noSalesProducts',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export sales report
     */
    public function exportSales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::with(['user', 'orderDetails.product'])
            ->whereBetween('timeorder', [$startDate, $endDate])
            ->where('trangthai', 4)
            ->get();

        $filename = 'sales_report_' . Carbon::now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'Order ID',
                'Customer',
                'Email',
                'Phone',
                'Order Date',
                'Total Amount',
                'Payment Method',
                'Status',
                'Items Count'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->madonhang,
                    $order->name,
                    $order->email,
                    $order->dienThoai,
                    $order->timeorder->format('Y-m-d H:i:s'),
                    $order->tongdonhang,
                    $order->pttt,
                    $order->status_text,
                    $order->orderDetails->count()
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper method to get sales by period
     */
    private function getSalesByPeriod($startDate, $endDate, $period)
    {
        $dateFormat = match ($period) {
            'weekly' => '%Y-%u',
            'monthly' => '%Y-%m',
            default => '%Y-%m-%d'
        };

        return Order::select(
            DB::raw("DATE_FORMAT(timeorder, '{$dateFormat}') as period"),
            DB::raw('COUNT(*) as orders'),
            DB::raw('SUM(CASE WHEN trangthai = 4 THEN tongdonhang ELSE 0 END) as revenue'),
            DB::raw('AVG(CASE WHEN trangthai = 4 THEN tongdonhang ELSE NULL END) as avg_order_value')
        )
            ->whereBetween('timeorder', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }
}
