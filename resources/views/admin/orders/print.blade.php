<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng #{{ $order->madonhang }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background: white;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 14px;
            color: #666;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .order-info {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }

        .order-info div {
            flex: 1;
        }

        .customer-info,
        .order-details {
            margin: 20px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .no-print {
                display: none;
            }
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-shipping {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-cancelled {
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer;">
            In đơn hàng
        </button>
    </div>

    <!-- Invoice Header -->
    <div class="invoice-header">
        <div class="company-name">THE PHONE STORE</div>
        <div class="company-info">
            Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh<br>
            Điện thoại: (028) 1234 5678 | Email: info@thephonestore.com<br>
            Website: www.thephonestore.com
        </div>
    </div>

    <!-- Invoice Title -->
    <div class="invoice-title">HÓA ĐON BÁN HÀNG</div>

    <!-- Order Information -->
    <div class="order-info">
        <div>
            <strong>Số hóa đơn:</strong> #{{ $order->madonhang }}<br>
            <strong>Ngày đặt:</strong> {{ $order->timeorder->format('d/m/Y H:i') }}<br>
            <strong>Trạng thái:</strong>
            <span class="status-badge status-{{ $order->trangthai == 1 ? 'pending' : ($order->trangthai == 2 ? 'confirmed' : ($order->trangthai == 3 ? 'shipping' : ($order->trangthai == 4 ? 'completed' : ($order->trangthai == 5 ? 'failed' : 'cancelled')))) }}">
                {{ $order->status_text }}
            </span>
        </div>
        <div style="text-align: right;">
            <strong>Phương thức thanh toán:</strong> {{ $order->pttt }}<br>
            <strong>Tình trạng:</strong> {{ $order->thanhtoan ? 'Đã thanh toán' : 'Chưa thanh toán' }}
        </div>
    </div>

    <!-- Customer Information -->
    <div class="customer-info">
        <div class="section-title">Thông tin khách hàng</div>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Họ tên:</strong> {{ $order->name }}<br>
                <strong>Số điện thoại:</strong> {{ $order->dienThoai }}<br>
                @if($order->email)
                <strong>Email:</strong> {{ $order->email }}<br>
                @endif
            </div>
            <div style="text-align: right; max-width: 50%;">
                <strong>Địa chỉ giao hàng:</strong><br>
                {{ $order->diachi }}
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-details">
        <div class="section-title">Chi tiết đơn hàng</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">STT</th>
                    <th style="width: 50%;">Sản phẩm</th>
                    <th style="width: 15%;" class="text-center">Số lượng</th>
                    <th style="width: 15%;" class="text-right">Đơn giá</th>
                    <th style="width: 15%;" class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $detail->tensp }}</strong><br>
                        <small>Mã SP: #{{ $detail->idsanpham }}</small>
                    </td>
                    <td class="text-center">{{ $detail->soluong }}</td>
                    <td class="text-right">{{ number_format($detail->dongia) }}đ</td>
                    <td class="text-right">{{ number_format($detail->total) }}đ</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Tạm tính:</strong></td>
                    <td class="text-right"><strong>{{ number_format($order->orderDetails->sum('total')) }}đ</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Phí vận chuyển:</strong></td>
                    <td class="text-right"><strong>{{ number_format($order->tongdonhang - $order->orderDetails->sum('total')) }}đ</strong></td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>TỔNG CỘNG:</strong></td>
                    <td class="text-right"><strong>{{ number_format($order->tongdonhang) }}đ</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Total in Words -->
    <div style="margin: 20px 0;">
        <strong>Số tiền bằng chữ:</strong> <em>{{ numberToWords($order->tongdonhang) }} đồng</em>
    </div>

    <!-- Notes -->
    @if($order->ghichu)
    <div style="margin: 20px 0;">
        <div class="section-title">Ghi chú</div>
        <p>{{ $order->ghichu }}</p>
    </div>
    @endif

    <!-- Terms and Conditions -->
    <div style="margin: 30px 0; font-size: 12px; color: #666;">
        <div class="section-title" style="font-size: 14px; color: #333;">Điều khoản và điều kiện</div>
        <ul style="margin: 0; padding-left: 20px;">
            <li>Quý khách vui lòng kiểm tra kỹ sản phẩm trước khi nhận hàng.</li>
            <li>Sản phẩm được bảo hành theo chính sách của nhà sản xuất.</li>
            <li>Đổi trả trong vòng 7 ngày với điều kiện sản phẩm còn nguyên vẹn.</li>
            <li>Mọi thắc mắc xin liên hệ hotline: (028) 1234 5678.</li>
        </ul>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <strong>Khách hàng</strong>
            <div class="signature-line">
                (Ký và ghi rõ họ tên)
            </div>
        </div>
        <div class="signature-box">
            <strong>Người giao hàng</strong>
            <div class="signature-line">
                (Ký và ghi rõ họ tên)
            </div>
        </div>
        <div class="signature-box">
            <strong>The Phone Store</strong>
            <div class="signature-line">
                (Ký và đóng dấu)
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="text-align: center; margin-top: 40px; font-size: 12px; color: #666;">
        <p>Cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
        <p>---</p>
        <p>Hóa đơn được in tự động từ hệ thống - Ngày in: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); };
    </script>
</body>

</html>
