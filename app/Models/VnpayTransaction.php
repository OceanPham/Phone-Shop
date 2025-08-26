<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VnpayTransaction extends Model
{
    use HasFactory;

    protected $table = 'tbl_vnpay_transaction';
    protected $primaryKey = 'id';

    protected $fillable = [
        'vnp_Amount',
        'vnp_BankCode',
        'vnp_BankTranNo',
        'vnp_CardType',
        'vnp_OrderInfo',
        'vnp_PayDate',
        'vnp_ResponseCode',
        'vnp_TmnCode',
        'vnp_TransactionNo',
        'vnp_TransactionStatus',
        'vnp_TxnRef',
        'vnp_SecureHashType',
        'vnp_SecureHash',
        'order_id',
    ];

    protected function casts(): array
    {
        return [
            'vnp_Amount' => 'decimal:2',
            'vnp_PayDate' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Accessors
     */
    public function getIsSuccessAttribute(): bool
    {
        return $this->vnp_ResponseCode === '00' && $this->vnp_TransactionStatus === '00';
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->vnp_Amount / 100, 0, ',', '.') . ' VND';
    }

    public function getStatusTextAttribute(): string
    {
        if ($this->is_success) {
            return 'Thành công';
        }

        return match ($this->vnp_ResponseCode) {
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
            '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.',
            '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
            '13' => 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP).',
            '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
            '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
            '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì.',
            '79' => 'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định.',
            '99' => 'Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)',
            default => 'Lỗi không xác định'
        };
    }

    /**
     * Scopes
     */
    public function scopeSuccessful($query)
    {
        return $query->where('vnp_ResponseCode', '00')
            ->where('vnp_TransactionStatus', '00');
    }

    public function scopeFailed($query)
    {
        return $query->where('vnp_ResponseCode', '!=', '00')
            ->orWhere('vnp_TransactionStatus', '!=', '00');
    }

    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }
}
