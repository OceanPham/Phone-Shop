<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subCategory'])->inStock();

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Sub category filter
        if ($request->filled('sub_category')) {
            $query->where('id_dmphu', $request->sub_category);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('don_gia', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('don_gia', '<=', $request->max_price);
        }

        // Search filter
        if ($request->filled('search')) {
            $query->searchByName($request->search);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('don_gia', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('don_gia', 'desc');
                break;
            case 'popular':
                $query->popular();
                break;
            case 'sale':
                $query->onSale()->orderBy('giam_gia', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = Category::withInStockProducts()->get();
        $subCategories = SubCategory::has('products')->get();
        $priceRange = Product::selectRaw('MIN(don_gia) as min_price, MAX(don_gia) as max_price')->first();

        return view('products.index', compact(
            'products',
            'categories',
            'subCategories',
            'priceRange',
            'sort'
        ));
    }

    public function show(Product $product)
    {
        // Increment view count
        $product->incrementViews();

        // Load relationships
        $product->load(['category', 'subCategory']);

        // Get related products
        $relatedProducts = $product->getRelatedProducts(6);

        // Get reviews with user info
        $reviews = $product->reviews()
            ->with('user')
            ->published()
            ->latest('date_create')
            ->paginate(10);

        // Get approved comments
        $comments = $product->comments()
            ->with('user')
            ->approved()
            ->latest('ngay_binhluan')
            ->get();

        // Calculate average rating
        $averageRating = $product->average_rating;
        $reviewCount = $product->review_count;

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'reviews',
            'comments',
            'averageRating',
            'reviewCount'
        ));
    }

    public function quickView(Product $product)
    {
        return response()->json([
            'id' => $product->masanpham,
            'name' => $product->tensp,
            'price' => $product->don_gia,
            'discounted_price' => $product->discounted_price,
            'formatted_price' => $product->formatted_price,
            'discount' => $product->giam_gia,
            'images' => $product->images_array,
            'description' => $product->mo_ta,
            'in_stock' => $product->in_stock,
            'stock_quantity' => $product->ton_kho,
            'average_rating' => $product->average_rating,
            'review_count' => $product->review_count,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        if (empty($keyword)) {
            return response()->json([]);
        }

        $products = Product::searchByName($keyword)
            ->inStock()
            ->limit(10)
            ->get(['masanpham', 'tensp', 'don_gia', 'giam_gia', 'images']);

        $suggestions = $products->map(function ($product) {
            return [
                'id' => $product->masanpham,
                'name' => $product->tensp,
                'price' => $product->formatted_price,
                'image' => $product->thumbnail,
                'url' => route('products.show', $product->masanpham)
            ];
        });

        return response()->json($suggestions);
    }

    /**
     * Store comment for product
     */
    public function storeComment(Request $request, Product $product)
    {
        $request->validate([
            'noi_dung' => 'required|string|max:1000',
        ]);

        if (!auth()->check()) {
            return back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        Comment::create([
            'noi_dung' => $request->noi_dung,
            'ma_sanpham' => $product->masanpham,
            'ma_nguoidung' => auth()->id(),
            'ngay_binhluan' => now(),
            'duyet' => false, // Need admin approval
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt.');
    }

    /**
     * Store review for product
     */
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating_star' => 'required|numeric|min:1|max:5',
            'noidung' => 'required|string|max:2000',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'order_id' => 'required|exists:orders,id',
        ]);

        if (!auth()->check()) {
            return back()->with('error', 'Bạn cần đăng nhập để đánh giá.');
        }

        // Check if user has ordered this product
        $order = auth()->user()->orders()
            ->where('id', $request->order_id)
            ->whereHas('orderDetails', function ($query) use ($product) {
                $query->where('idsanpham', $product->masanpham);
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua.');
        }

        // Check if already reviewed
        $existingReview = Review::where('iduser', auth()->id())
            ->where('idsanpham', $product->masanpham)
            ->where('iddonhang', $order->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/reviews', $filename);
                $images[] = $filename;
            }
        }

        Review::create([
            'iduser' => auth()->id(),
            'idsanpham' => $product->masanpham,
            'iddonhang' => $order->id,
            'rating_star' => $request->rating_star,
            'noidung' => $request->noidung,
            'images_review' => implode(',', $images),
            'date_create' => now(),
            'trangthai_review' => true, // Auto approve reviews
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
