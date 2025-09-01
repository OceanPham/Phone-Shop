<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\AIAssistantService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category'])->latest();

        // Search filter
        if ($request->filled('search')) {
            $query->where('tensp', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('ma_danhmuc', $request->category);
        }

        // Stock filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('ton_kho', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('ton_kho', '>', 0)->where('ton_kho', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('ton_kho', '<=', 0);
                    break;
            }
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        Log::info('ProductController@store called');
        try {
            $request->validate([
                'tensp' => 'required|string|max:255',
                'ma_danhmuc' => 'required|exists:tbl_danhmuc,ma_danhmuc',
                'don_gia' => 'required|numeric|min:1',
                'wholesale_price' => 'nullable|numeric|min:0',
                'ton_kho' => 'required|integer|min:0',
                'giam_gia' => 'nullable|integer|min:0|max:100',
                'mo_ta' => 'nullable|string',
                'information' => 'nullable|string',
                'so_luot_xem' => 'nullable|integer|min:0',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
                // Các trường mới
                'product_name' => 'nullable|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'product_line' => 'nullable|string|max:255',
                'sku' => 'nullable|string|max:255',
                'imei_serial_number' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:50',
                'manufacture_date' => 'nullable|date',
                'display' => 'nullable|string|max:255',
                'cpu_chipset' => 'nullable|string|max:255',
                'ram' => 'nullable|string|max:255',
                'internal_storage' => 'nullable|string|max:255',
                'operating_system' => 'nullable|string|max:255',
                'battery' => 'nullable|string|max:255',
                'rear_camera' => 'nullable|string|max:255',
                'front_camera' => 'nullable|string|max:255',
                'camera' => 'nullable|string',
                'sim_support' => 'nullable|string|max:255',
                'network' => 'nullable|string|max:255',
                'wifi_bluetooth_nfc' => 'nullable|string|max:255',
                'ports_connector' => 'nullable|string|max:255',
                'connectivity_and_network' => 'nullable|string',
                'dimensions_and_weight' => 'nullable|string|max:255',
                'frame_and_back_materials' => 'nullable|string|max:255',
                'colors' => 'nullable|string|max:255',
                'water_dust_resistance_ip' => 'nullable|string|max:255',
                'design_and_dimensions' => 'nullable|string',
                'security' => 'nullable|string|max:255',
                'charging_support' => 'nullable|string|max:255',
                'special_features' => 'nullable|string',
                'manufacturer_warranty' => 'nullable|string|max:255',
                'store_warranty' => 'nullable|string|max:255',
                'commercial_information' => 'nullable|string',
                'inventory_and_sales' => 'nullable|string',
                'units_received' => 'nullable|integer|min:0',
                'supplier' => 'nullable|string|max:255',
            ]);

            // Handle image uploads
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads'), $filename);
                    $images[] = $filename;
                }
            }

            $product = Product::create([
                'tensp' => $request->tensp,
                'ma_danhmuc' => $request->ma_danhmuc,
                'don_gia' => $request->don_gia,
                'ton_kho' => $request->ton_kho,
                'giam_gia' => $request->giam_gia ?? 0,
                'mo_ta' => $request->mo_ta,
                'information' => $request->information,
                'images' => implode(',', $images),
                'so_luot_xem' => $request->so_luot_xem ?? 0,
                'promote' => $request->has('promote') ? 1 : 0,
                'dac_biet' => $request->has('dac_biet') ? 1 : 0,
                'ngay_nhap' => now(),
                // Các trường mới
                'wholesale_price' => $request->wholesale_price,
                'product_name' => $request->product_name,
                'manufacturer' => $request->manufacturer,
                'product_line' => $request->product_line,
                'sku' => $request->sku,
                'imei_serial_number' => $request->imei_serial_number,
                'condition' => $request->condition,
                'manufacture_date' => $request->manufacture_date,
                'display' => $request->display,
                'cpu_chipset' => $request->cpu_chipset,
                'ram' => $request->ram,
                'internal_storage' => $request->internal_storage,
                'operating_system' => $request->operating_system,
                'battery' => $request->battery,
                'rear_camera' => $request->rear_camera,
                'front_camera' => $request->front_camera,
                'camera' => $request->camera,
                'sim_support' => $request->sim_support,
                'network' => $request->network,
                'wifi_bluetooth_nfc' => $request->wifi_bluetooth_nfc,
                'ports_connector' => $request->ports_connector,
                'connectivity_and_network' => $request->connectivity_and_network,
                'dimensions_and_weight' => $request->dimensions_and_weight,
                'frame_and_back_materials' => $request->frame_and_back_materials,
                'colors' => $request->colors,
                'water_dust_resistance_ip' => $request->water_dust_resistance_ip,
                'design_and_dimensions' => $request->design_and_dimensions,
                'security' => $request->security,
                'charging_support' => $request->charging_support,
                'special_features' => $request->special_features,
                'manufacturer_warranty' => $request->manufacturer_warranty,
                'store_warranty' => $request->store_warranty,
                'commercial_information' => $request->commercial_information,
                'inventory_and_sales' => $request->inventory_and_sales,
                'units_received' => $request->units_received,
                'supplier' => $request->supplier,
            ]);

            // Add to AI Assistant Vector Database
            $aiService = new AIAssistantService();
            $aiService->putItem($product);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được tạo thành công!'
                ]);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Product store error: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tạo sản phẩm'
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sản phẩm')->withInput();
        }
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['category']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        // Return JSON for AJAX requests (modal edit)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'product' => [
                    'masanpham' => $product->masanpham,
                    'tensp' => $product->tensp,
                    'ma_danhmuc' => $product->ma_danhmuc,
                    'don_gia' => $product->don_gia,
                    'wholesale_price' => $product->wholesale_price,
                    'ton_kho' => $product->ton_kho,
                    'giam_gia' => (int) ($product->giam_gia ?? 0),
                    'mo_ta' => $product->mo_ta,
                    'information' => $product->information,
                    'so_luot_xem' => $product->so_luot_xem,
                    'promote' => $product->promote ? 1 : 0,
                    'dac_biet' => $product->dac_biet ? 1 : 0,
                    'images' => $product->images_array ?? [],
                    // Các trường mới
                    'product_name' => $product->product_name,
                    'manufacturer' => $product->manufacturer,
                    'product_line' => $product->product_line,
                    'sku' => $product->sku,
                    'imei_serial_number' => $product->imei_serial_number,
                    'condition' => $product->condition,
                    'manufacture_date' => $product->manufacture_date,
                    'display' => $product->display,
                    'cpu_chipset' => $product->cpu_chipset,
                    'ram' => $product->ram,
                    'internal_storage' => $product->internal_storage,
                    'operating_system' => $product->operating_system,
                    'battery' => $product->battery,
                    'rear_camera' => $product->rear_camera,
                    'front_camera' => $product->front_camera,
                    'camera' => $product->camera,
                    'sim_support' => $product->sim_support,
                    'network' => $product->network,
                    'wifi_bluetooth_nfc' => $product->wifi_bluetooth_nfc,
                    'ports_connector' => $product->ports_connector,
                    'connectivity_and_network' => $product->connectivity_and_network,
                    'dimensions_and_weight' => $product->dimensions_and_weight,
                    'frame_and_back_materials' => $product->frame_and_back_materials,
                    'colors' => $product->colors,
                    'water_dust_resistance_ip' => $product->water_dust_resistance_ip,
                    'design_and_dimensions' => $product->design_and_dimensions,
                    'security' => $product->security,
                    'charging_support' => $product->charging_support,
                    'special_features' => $product->special_features,
                    'manufacturer_warranty' => $product->manufacturer_warranty,
                    'store_warranty' => $product->store_warranty,
                    'commercial_information' => $product->commercial_information,
                    'inventory_and_sales' => $product->inventory_and_sales,
                    'units_received' => $product->units_received,
                    'supplier' => $product->supplier,
                ],
                'categories' => $categories->map(function ($cat) {
                    return [
                        'ma_danhmuc' => $cat->ma_danhmuc,
                        'ten_danhmuc' => $cat->ten_danhmuc
                    ];
                })
            ]);
        }

        // Return view for regular requests
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        \Log::info('=== UPDATE METHOD CALLED ===');
        \Log::info('Product ID: ' . $product->masanpham);
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('Request method: ' . $request->method());
        \Log::info('Content-Type: ' . $request->header('Content-Type'));

        try {
            // Laravel standard validation
            $validated = $request->validate([
                'tensp' => 'required|string|max:255',
                'ma_danhmuc' => 'required|exists:tbl_danhmuc,ma_danhmuc',
                'don_gia' => 'required|numeric|min:1',
                'wholesale_price' => 'nullable|numeric|min:0',
                'ton_kho' => 'required|integer|min:0',
                'giam_gia' => 'nullable|integer|min:0|max:100',
                'mo_ta' => 'nullable|string',
                'information' => 'nullable|string',
                'so_luot_xem' => 'nullable|integer|min:0',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                // Các trường mới
                'product_name' => 'nullable|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'product_line' => 'nullable|string|max:255',
                'sku' => 'nullable|string|max:255',
                'imei_serial_number' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:50',
                'manufacture_date' => 'nullable|date',
                'display' => 'nullable|string|max:255',
                'cpu_chipset' => 'nullable|string|max:255',
                'ram' => 'nullable|string|max:255',
                'internal_storage' => 'nullable|string|max:255',
                'operating_system' => 'nullable|string|max:255',
                'battery' => 'nullable|string|max:255',
                'rear_camera' => 'nullable|string|max:255',
                'front_camera' => 'nullable|string|max:255',
                'camera' => 'nullable|string',
                'sim_support' => 'nullable|string|max:255',
                'network' => 'nullable|string|max:255',
                'wifi_bluetooth_nfc' => 'nullable|string|max:255',
                'ports_connector' => 'nullable|string|max:255',
                'connectivity_and_network' => 'nullable|string',
                'dimensions_and_weight' => 'nullable|string|max:255',
                'frame_and_back_materials' => 'nullable|string|max:255',
                'colors' => 'nullable|string|max:255',
                'water_dust_resistance_ip' => 'nullable|string|max:255',
                'design_and_dimensions' => 'nullable|string',
                'security' => 'nullable|string|max:255',
                'charging_support' => 'nullable|string|max:255',
                'special_features' => 'nullable|string',
                'manufacturer_warranty' => 'nullable|string|max:255',
                'store_warranty' => 'nullable|string|max:255',
                'commercial_information' => 'nullable|string',
                'inventory_and_sales' => 'nullable|string',
                'units_received' => 'nullable|integer|min:0',
                'supplier' => 'nullable|string|max:255',
            ]);

            \Log::info('Validation passed, proceeding with update');

            $images = $product->images_array ?? [];

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads'), $filename);
                    $images[] = $filename;
                }
            }

            // Remove deleted images
            if ($request->filled('removed_images')) {
                $removedImages = explode(',', $request->removed_images);
                foreach ($removedImages as $removedImage) {
                    // Delete physical file
                    $imagePath = public_path('uploads/' . $removedImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    // Remove from array
                    $images = array_filter($images, function ($img) use ($removedImage) {
                        return $img !== $removedImage;
                    });
                }
            }

            $product->update([
                'tensp' => $request->tensp,
                'ma_danhmuc' => $request->ma_danhmuc,
                'don_gia' => $request->don_gia,
                'ton_kho' => $request->ton_kho,
                'giam_gia' => $request->giam_gia ?? 0,
                'mo_ta' => $request->mo_ta,
                'information' => $request->information,
                'images' => implode(',', $images),
                'promote' => $request->has('promote') ? 1 : 0,
                'dac_biet' => $request->has('dac_biet') ? 1 : 0,
                'so_luot_xem' => $request->so_luot_xem ?? $product->so_luot_xem,
                // Các trường mới
                'wholesale_price' => $request->wholesale_price,
                'product_name' => $request->product_name,
                'manufacturer' => $request->manufacturer,
                'product_line' => $request->product_line,
                'sku' => $request->sku,
                'imei_serial_number' => $request->imei_serial_number,
                'condition' => $request->condition,
                'manufacture_date' => $request->manufacture_date,
                'display' => $request->display,
                'cpu_chipset' => $request->cpu_chipset,
                'ram' => $request->ram,
                'internal_storage' => $request->internal_storage,
                'operating_system' => $request->operating_system,
                'battery' => $request->battery,
                'rear_camera' => $request->rear_camera,
                'front_camera' => $request->front_camera,
                'camera' => $request->camera,
                'sim_support' => $request->sim_support,
                'network' => $request->network,
                'wifi_bluetooth_nfc' => $request->wifi_bluetooth_nfc,
                'ports_connector' => $request->ports_connector,
                'connectivity_and_network' => $request->connectivity_and_network,
                'dimensions_and_weight' => $request->dimensions_and_weight,
                'frame_and_back_materials' => $request->frame_and_back_materials,
                'colors' => $request->colors,
                'water_dust_resistance_ip' => $request->water_dust_resistance_ip,
                'design_and_dimensions' => $request->design_and_dimensions,
                'security' => $request->security,
                'charging_support' => $request->charging_support,
                'special_features' => $request->special_features,
                'manufacturer_warranty' => $request->manufacturer_warranty,
                'store_warranty' => $request->store_warranty,
                'commercial_information' => $request->commercial_information,
                'inventory_and_sales' => $request->inventory_and_sales,
                'units_received' => $request->units_received,
                'supplier' => $request->supplier,
            ]);

            // Update AI Assistant Vector Database
            $aiService = new AIAssistantService();
            $aiService->putItem($product);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được cập nhật thành công!'
                ]);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Product update error: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật sản phẩm'
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm')->withInput();
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        try {
            // Delete product images
            if ($product->images) {
                $imageArray = $product->images_array; // Use correct accessor name
                if (!empty($imageArray)) {
                    foreach ($imageArray as $image) {
                        $imagePath = public_path('uploads/' . $image);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }
            }

            $productName = $product->tensp;
            $productId = $product->masanpham;
            $product->delete();

            // Remove from AI Assistant Vector Database
            $aiService = new AIAssistantService();
            $aiService->deleteItem($productId);

            // Return JSON response for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Sản phẩm \"{$productName}\" đã được xóa thành công!"
                ]);
            }

            // Fallback for regular requests
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.products.index')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm!');
        }
    }

    /**
     * Update product stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'ton_kho' => 'required|integer|min:0',
        ]);

        $product->update([
            'ton_kho' => $request->ton_kho,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật tồn kho thành công!',
            'stock' => $product->ton_kho,
        ]);
    }

    /**
     * Toggle product visibility
     */
    public function toggleVisibility(Product $product)
    {
        $product->update([
            'hien_thi' => !($product->hien_thi ?? true),
        ]);

        return response()->json([
            'success' => true,
            'message' => $product->hien_thi ? 'Sản phẩm đã được hiển thị' : 'Sản phẩm đã được ẩn',
            'visible' => $product->hien_thi,
        ]);
    }



    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,hide,show,update_category',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:tbl_sanpham,masanpham',
            'category_id' => 'nullable|exists:tbl_danhmuc,ma_danhmuc',
        ]);

        $products = Product::whereIn('masanpham', $request->products);

        switch ($request->action) {
            case 'delete':
                foreach ($products->get() as $product) {
                    // Delete images
                    if ($product->images) {
                        foreach ($product->images_array as $image) {
                            $imagePath = public_path('uploads/' . $image);
                            if (file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                        }
                    }
                }
                $count = $products->count();
                $products->delete();
                $message = "Đã xóa {$count} sản phẩm thành công!";
                break;

            case 'hide':
                $count = $products->update(['hien_thi' => false]);
                $message = "Đã ẩn {$count} sản phẩm thành công!";
                break;

            case 'show':
                $count = $products->update(['hien_thi' => true]);
                $message = "Đã hiển thị {$count} sản phẩm thành công!";
                break;

            case 'update_category':
                if (!$request->category_id) {
                    return back()->withErrors(['category_id' => 'Vui lòng chọn danh mục!']);
                }
                $count = $products->update(['ma_danhmuc' => $request->category_id]);
                $message = "Đã cập nhật danh mục cho {$count} sản phẩm thành công!";
                break;
        }

        return redirect()->route('admin.products.index')->with('success', $message);
    }
}
