<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    const CART_SESSION_KEY = 'cart';

    /**
     * Add product to cart
     */
    public function addToCart(int $productId, int $quantity = 1): array
    {
        $product = Product::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại'];
        }

        if (!$product->in_stock) {
            return ['success' => false, 'message' => 'Sản phẩm đã hết hàng'];
        }

        $cart = $this->getCart();
        $currentQuantity = $cart->get($productId)['quantity'] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->ton_kho) {
            return [
                'success' => false,
                'message' => "Chỉ còn {$product->ton_kho} sản phẩm trong kho"
            ];
        }

        $cartItem = [
            'id' => $product->masanpham,
            'name' => $product->tensp,
            'price' => $product->discounted_price,
            'original_price' => $product->don_gia,
            'discount' => $product->giam_gia,
            'quantity' => $newQuantity,
            'image' => $product->thumbnail,
            'category' => $product->category->ten_danhmuc ?? '',
            'category_id' => $product->ma_danhmuc,
            'max_stock' => $product->ton_kho,
        ];

        $cart->put($productId, $cartItem);
        $this->saveCart($cart);

        return [
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
    }

    /**
     * Update cart item quantity
     */
    public function updateCartItem(int $productId, int $quantity): array
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($productId);
        }

        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại'];
        }

        if ($quantity > $product->ton_kho) {
            return [
                'success' => false,
                'message' => "Chỉ còn {$product->ton_kho} sản phẩm trong kho"
            ];
        }

        $cart = $this->getCart();

        if (!$cart->has($productId)) {
            return ['success' => false, 'message' => 'Sản phẩm không có trong giỏ hàng'];
        }

        $cartItem = $cart->get($productId);
        $cartItem['quantity'] = $quantity;
        $cart->put($productId, $cartItem);

        $this->saveCart($cart);

        return [
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(int $productId): array
    {
        $cart = $this->getCart();
        $cart->forget($productId);
        $this->saveCart($cart);

        return [
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->getCartTotal()
        ];
    }

    /**
     * Get cart items
     */
    public function getCartItems(): Collection
    {
        return $this->getCart();
    }

    /**
     * Get cart total
     */
    public function getCartTotal(): float
    {
        return $this->getCart()->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Get cart count (total items)
     */
    public function getCartCount(): int
    {
        return $this->getCart()->sum('quantity');
    }

    /**
     * Get formatted cart total
     */
    public function getFormattedCartTotal(): string
    {
        return number_format($this->getCartTotal()) . ' VND';
    }

    /**
     * Clear cart
     */
    public function clearCart(): void
    {
        session()->forget(self::CART_SESSION_KEY);
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return $this->getCart()->isEmpty();
    }

    /**
     * Validate cart items against current stock
     */
    public function validateCart(): array
    {
        $cart = $this->getCart();
        $errors = [];
        $hasChanges = false;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                $cart->forget($productId);
                $errors[] = "Sản phẩm '{$item['name']}' không còn tồn tại";
                $hasChanges = true;
                continue;
            }

            if (!$product->in_stock) {
                $cart->forget($productId);
                $errors[] = "Sản phẩm '{$product->tensp}' đã hết hàng";
                $hasChanges = true;
                continue;
            }

            if ($item['quantity'] > $product->ton_kho) {
                $item['quantity'] = $product->ton_kho;
                $cart->put($productId, $item);
                $errors[] = "Số lượng sản phẩm '{$product->tensp}' đã được điều chỉnh về {$product->ton_kho}";
                $hasChanges = true;
            }

            // Update price if changed
            if ($item['price'] != $product->discounted_price) {
                $item['price'] = $product->discounted_price;
                $item['original_price'] = $product->don_gia;
                $item['discount'] = $product->giam_gia;
                $cart->put($productId, $item);
                $hasChanges = true;
            }
        }

        if ($hasChanges) {
            $this->saveCart($cart);
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'has_changes' => $hasChanges
        ];
    }

    /**
     * Get cart summary for checkout
     */
    public function getCartSummary(): array
    {
        $cart = $this->getCartItems();
        $subtotal = $this->getCartTotal();

        // Calculate total discount from cart items
        $discount = $cart->sum(function ($item) {
            if ($item['discount'] > 0) {
                $originalPrice = $item['original_price'];
                $discountAmount = $originalPrice * ($item['discount'] / 100);
                return $discountAmount * $item['quantity'];
            }
            return 0;
        });

        $shipping = 30000; // Fixed shipping fee (30,000 VND)
        $tax = 0; // Calculate tax if needed
        $total = $subtotal + $shipping + $tax;

        return [
            'items' => $cart->values(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'formatted_subtotal' => number_format($subtotal) . ' VND',
            'formatted_discount' => number_format($discount) . ' VND',
            'formatted_shipping' => number_format($shipping) . ' VND',
            'formatted_tax' => number_format($tax) . ' VND',
            'formatted_total' => number_format($total) . ' VND',
        ];
    }

    /**
     * Get cart from session
     */
    private function getCart(): Collection
    {
        return collect(session()->get(self::CART_SESSION_KEY, []));
    }

    /**
     * Save cart to session
     */
    private function saveCart(Collection $cart): void
    {
        session()->put(self::CART_SESSION_KEY, $cart->toArray());
    }
}
