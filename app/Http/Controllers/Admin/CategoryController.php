<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search filter
        if ($request->filled('search')) {
            $query->where('ten_danhmuc', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(15)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_danhmuc' => 'required|string|max:255|unique:tbl_danhmuc,ten_danhmuc',
            'mo_ta' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'ten_danhmuc' => $request->ten_danhmuc,
            'mo_ta' => $request->mo_ta,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $filename);
            $data['hinh_anh'] = $filename;
        }

        Category::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được tạo thành công!'
        ]);
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'ten_danhmuc' => 'required|string|max:255|unique:tbl_danhmuc,ten_danhmuc,' . $category->ma_danhmuc . ',ma_danhmuc',
            'mo_ta' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'ten_danhmuc' => $request->ten_danhmuc,
            'mo_ta' => $request->mo_ta,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->hinh_anh) {
                $oldImagePath = public_path('uploads/categories/' . $category->hinh_anh);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $filename);
            $data['hinh_anh'] = $filename;
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được cập nhật thành công!'
        ]);
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa danh mục này vì còn có sản phẩm!'
            ], 422);
        }

        // Delete category image
        if ($category->hinh_anh) {
            $imagePath = public_path('uploads/categories/' . $category->hinh_anh);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được xóa thành công!'
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,show,hide',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:tbl_danhmuc,ma_danhmuc',
        ]);

        $categories = Category::whereIn('ma_danhmuc', $request->categories);

        switch ($request->action) {
            case 'delete':
                // Check if any category has products
                $categoriesWithProducts = $categories->withCount('products')->get()->filter(function ($cat) {
                    return $cat->products_count > 0;
                });

                if ($categoriesWithProducts->count() > 0) {
                    return back()->withErrors([
                        'bulk' => 'Không thể xóa ' . $categoriesWithProducts->count() . ' danh mục vì còn có sản phẩm!'
                    ]);
                }

                // Delete images
                foreach ($categories->get() as $category) {
                    if ($category->hinh_anh) {
                        $imagePath = public_path('uploads/categories/' . $category->hinh_anh);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }

                $count = $categories->count();
                $categories->delete();
                $message = "Đã xóa {$count} danh mục thành công!";
                break;

            case 'hide':
                $count = $categories->update(['hien_thi' => false]);
                $message = "Đã ẩn {$count} danh mục thành công!";
                break;

            case 'show':
                $count = $categories->update(['hien_thi' => true]);
                $message = "Đã hiển thị {$count} danh mục thành công!";
                break;
        }

        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    /**
     * Toggle category visibility
     */
    public function toggleVisibility(Category $category)
    {
        $category->update([
            'hien_thi' => !($category->hien_thi ?? true),
        ]);

        return response()->json([
            'success' => true,
            'message' => $category->hien_thi ? 'Danh mục đã được hiển thị' : 'Danh mục đã được ẩn',
            'visible' => $category->hien_thi,
        ]);
    }

    /**
     * Get category statistics
     */
    public function stats()
    {
        $stats = [
            'total_categories' => Category::count(),
            'visible_categories' => Category::where('hien_thi', true)->count(),
            'hidden_categories' => Category::where('hien_thi', false)->count(),
            'categories_with_products' => Category::has('products')->count(),
            'empty_categories' => Category::doesntHave('products')->count(),
        ];

        return response()->json($stats);
    }
}
