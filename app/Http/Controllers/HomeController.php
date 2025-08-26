<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (dac_biet = true)
        $featuredProducts = Product::featured()
            ->inStock()
            ->limit(8)
            ->get();

        // Get sale products (giam_gia > 0)
        $saleProducts = Product::onSale()
            ->inStock()
            ->orderBy('giam_gia', 'desc')
            ->limit(8)
            ->get();

        // Get latest products
        $newProducts = Product::latest()
            ->inStock()
            ->limit(8)
            ->get();

        // Get popular products (by views)
        $popularProducts = Product::popular()
            ->inStock()
            ->limit(8)
            ->get();

        // Get main categories with products
        $categories = Category::withInStockProducts()
            ->limit(6)
            ->get();

        // Get banners if the model exists
        $banners = collect(); // Placeholder for now
        // $banners = Banner::active()->latest()->get();

        return view('home.index', compact(
            'featuredProducts',
            'saleProducts',
            'newProducts',
            'popularProducts',
            'categories',
            'banners'
        ));
    }

    /**
     * Search products (could be moved to ProductController)
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Product::inStock();

        if ($keyword) {
            $query->searchByName($keyword);
        }

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        if ($minPrice || $maxPrice) {
            $query->priceRange($minPrice, $maxPrice);
        }

        $products = $query->paginate(12);
        $categories = Category::withInStockProducts()->get();

        return view('products.index', compact('products', 'categories', 'keyword'));
    }
}
