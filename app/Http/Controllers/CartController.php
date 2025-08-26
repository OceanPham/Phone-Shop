<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * Display cart page
     */
    public function index()
    {
        // Validate cart items against current stock
        $validation = $this->cartService->validateCart();

        $rawCartItems = $this->cartService->getCartItems();
        $cartSummary = $this->cartService->getCartSummary();

        // Transform cart items to include Product objects
        $cartItems = $rawCartItems->map(function ($item) {
            $product = \App\Models\Product::find($item['id']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
        })->filter(function ($item) {
            return $item['product'] !== null; // Remove items where product is not found
        });

        if (!$validation['valid']) {
            $errorMessage = 'Một số sản phẩm trong giỏ hàng đã thay đổi: ' . implode(', ', $validation['errors']);
            session()->flash('warning', $errorMessage);
        }

        return view('cart.index', compact('cartItems', 'cartSummary'));
    }

    /**
     * Add product to cart
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:tbl_sanpham,masanpham',
                'quantity' => 'integer|min:1|max:999'
            ]);

            $result = $this->cartService->addToCart(
                $request->product_id,
                $request->quantity ?? 1
            );

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($result);
            }

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
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
            \Log::error('Cart store error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng'
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:999'
        ]);

        $result = $this->cartService->updateCartItem($productId, $request->quantity);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy($productId)
    {
        $result = $this->cartService->removeFromCart($productId);

        if (request()->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $this->cartService->clearCart();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa toàn bộ giỏ hàng']);
        }

        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }

    /**
     * Get cart data for API/AJAX
     */
    public function getCart()
    {
        $cartSummary = $this->cartService->getCartSummary();

        return response()->json([
            'success' => true,
            'data' => $cartSummary
        ]);
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount()
    {
        return response()->json([
            'count' => $this->cartService->getCartCount(),
            'total' => $this->cartService->getFormattedCartTotal()
        ]);
    }

    /**
     * Validate cart before checkout
     */
    public function validateCart()
    {
        $validation = $this->cartService->validateCart();

        return response()->json([
            'valid' => $validation['valid'],
            'errors' => $validation['errors'],
            'cart_count' => $this->cartService->getCartCount(),
            'cart_total' => $this->cartService->getFormattedCartTotal()
        ]);
    }
}
