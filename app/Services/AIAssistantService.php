<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIAssistantService
{
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = config('ai_assistant.url', 'http://localhost:8000');
        $this->timeout = config('ai_assistant.timeout', 30);
    }

    /**
     * Add or update product in AI Assistant vector database
     */
    public function putItem(Product $product): bool
    {
        try {
            $productData = $this->formatProductData($product);

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/put-item', $productData);

            if ($response->successful()) {
                Log::info('AI Assistant: Product added/updated successfully', [
                    'product_id' => $product->masanpham,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::warning('AI Assistant: Failed to add/update product', [
                    'product_id' => $product->masanpham,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('AI Assistant: Error adding/updating product', [
                'product_id' => $product->masanpham,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete product from AI Assistant vector database
     */
    public function deleteItem(int $productId): bool
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/delete-item', [
                    'id' => $productId
                ]);

            if ($response->successful()) {
                Log::info('AI Assistant: Product deleted successfully', [
                    'product_id' => $productId,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::warning('AI Assistant: Failed to delete product', [
                    'product_id' => $productId,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('AI Assistant: Error deleting product', [
                'product_id' => $productId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check AI Assistant service health
     */
    public function healthCheck(): bool
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl . '/health');
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('AI Assistant: Health check failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Format product data according to AI Assistant API requirements
     */
    private function formatProductData(Product $product): array
    {
        // Get category information
        $category = $product->category;
        $categoryName = $category ? $category->ten_danhmuc : 'Unknown';

        // Parse images
        $images = $product->images_array ?? [];

        // Parse specifications
        $specs = $this->parseSpecifications($product->information ?? '');

        return [
            'id' => (string) $product->masanpham,
            'name' => $product->tensp,
            'description' => $product->mo_ta ?? '',
            'technical_specifications' => $product->information ?? '',
            'camera' => $specs['camera'] ?? '',
            'connectivity_and_network' => $specs['connectivity'] ?? '',
            'design_and_dimensions' => $specs['design'] ?? '',
            'special_features' => $specs['features'] ?? '',
            'commercial_information' => $specs['commercial'] ?? '',
            'inventory_and_sales' => $specs['inventory'] ?? '',
            'product_name' => $product->tensp,
            'manufacturer' => $this->extractManufacturer($product->tensp),
            'product_line' => $this->extractProductLine($product->tensp),
            'manufacture_date' => $product->ngay_nhap ? $product->ngay_nhap->format('Y-m-d') : date('Y-m-d'),
            'stock_in_date' => $product->ngay_nhap ? $product->ngay_nhap->format('Y-m-d') : date('Y-m-d'),
            'imei_serial_number' => $this->generateIMEI($product->masanpham),
            'display' => $specs['display'] ?? '',
            'cpu_chipset' => $specs['cpu'] ?? '',
            'ram' => $specs['ram'] ?? '',
            'internal_storage' => $specs['storage'] ?? '',
            'operating_system' => $specs['os'] ?? '',
            'battery' => $specs['battery'] ?? '',
            'rear_camera' => $specs['rear_camera'] ?? '',
            'front_camera' => $specs['front_camera'] ?? '',
            'sim_support' => $specs['sim'] ?? '',
            'network' => $specs['network'] ?? '',
            'wifi_bluetooth_nfc' => $specs['wifi'] ?? '',
            'ports_connector' => $specs['ports'] ?? '',
            'dimensions_and_weight' => $specs['dimensions'] ?? '',
            'frame_and_back_materials' => $specs['materials'] ?? '',
            'colors' => $specs['colors'] ?? '',
            'security' => $specs['security'] ?? '',
            'water_dust_resistance_ip' => $specs['water_resistance'] ?? '',
            'charging_support' => $specs['charging'] ?? '',
            'wholesale_price' => (int) ($product->don_gia * 0.8), // Giả sử giá nhập = 80% giá bán
            'retail_price' => (int) $product->don_gia,
            'condition' => 'Mới',
            'manufacturer_warranty' => '12 tháng',
            'store_warranty' => 'Đổi mới 30 ngày nếu lỗi NSX',
            'sku' => $this->generateSKU($product),
            'units_received' => $product->ton_kho + rand(10, 50), // Giả sử đã nhập nhiều hơn tồn kho
            'in_stock_units' => $product->ton_kho,
            'supplier' => $this->getSupplier($categoryName),
        ];
    }

    /**
     * Parse product specifications from information field
     */
    private function parseSpecifications(string $information): array
    {
        $specs = [];

        // Extract display information
        if (preg_match('/Màn hình[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['display'] = trim($matches[1]);
        }

        // Extract CPU information
        if (preg_match('/Chip[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['cpu'] = trim($matches[1]);
        }

        // Extract RAM information
        if (preg_match('/RAM[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['ram'] = trim($matches[1]);
        }

        // Extract storage information
        if (preg_match('/Pin[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['battery'] = trim($matches[1]);
        }

        // Extract camera information
        if (preg_match('/Camera sau[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['rear_camera'] = trim($matches[1]);
        }

        if (preg_match('/Camera trước[:\s]*([^;]+)/i', $information, $matches)) {
            $specs['front_camera'] = trim($matches[1]);
        }

        return $specs;
    }

    /**
     * Extract manufacturer from product name
     */
    private function extractManufacturer(string $productName): string
    {
        $manufacturers = ['Apple', 'Samsung', 'Xiaomi', 'OPPO', 'Vivo', 'Huawei', 'OnePlus', 'Google'];

        foreach ($manufacturers as $manufacturer) {
            if (stripos($productName, $manufacturer) !== false) {
                return $manufacturer;
            }
        }

        return 'Unknown';
    }

    /**
     * Extract product line from product name
     */
    private function extractProductLine(string $productName): string
    {
        // Extract common product lines
        if (preg_match('/(iPhone|Galaxy|Redmi|Mi|Reno|V|P|Mate|Pixel)\s+(\d+)/i', $productName, $matches)) {
            return $matches[1] . ' ' . $matches[2];
        }

        return $productName;
    }

    /**
     * Generate IMEI number
     */
    private function generateIMEI(int $productId): string
    {
        // Generate a fake IMEI based on product ID
        $baseIMEI = '35' . str_pad($productId, 13, '0', STR_PAD_LEFT);
        return substr($baseIMEI, 0, 15);
    }

    /**
     * Generate SKU
     */
    private function generateSKU(Product $product): string
    {
        $manufacturer = $this->extractManufacturer($product->tensp);
        $productLine = $this->extractProductLine($product->tensp);

        // Clean product line for SKU
        $sku = str_replace([' ', '-'], '', $productLine);
        $sku = strtoupper($sku);

        return $sku . '-' . $product->masanpham;
    }

    /**
     * Get supplier based on category
     */
    private function getSupplier(string $categoryName): string
    {
        $suppliers = [
            'iPhone' => 'Apple Việt Nam (Hotline: 1800-1127)',
            'Samsung' => 'Samsung Việt Nam (Hotline: 1800-588-889)',
            'Xiaomi' => 'Xiaomi Việt Nam (Hotline: 1900-1234)',
            'OPPO' => 'OPPO Việt Nam (Hotline: 1900-1234)',
            'Vivo' => 'Vivo Việt Nam (Hotline: 1900-1234)',
        ];

        foreach ($suppliers as $brand => $supplier) {
            if (stripos($categoryName, $brand) !== false) {
                return $supplier;
            }
        }

        return 'Nhà cung cấp chính thức';
    }
}
