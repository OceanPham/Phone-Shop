/**
 * Cart functionality for The Phone Store
 */

// Add to cart functionality
function addToCart(productId, quantity = 1) {
    // Get button element if called from onclick
    const button = event?.target?.closest('button');
    const originalContent = button?.innerHTML;

    // Show loading state
    if (button) {
        button.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang thêm...
            </span>
        `;
        button.disabled = true;
    }

    // Create FormData for better Laravel compatibility
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success state
                if (button) {
                    button.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Đã thêm!
                    </span>
                `;

                    // Update button styling
                    button.classList.remove('from-blue-600', 'to-purple-600', 'bg-blue-600');
                    button.classList.add('from-green-500', 'to-green-600', 'bg-green-600');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('from-green-500', 'to-green-600', 'bg-green-600');
                        button.classList.add('from-blue-600', 'to-purple-600', 'bg-blue-600');
                        button.disabled = false;
                    }, 2000);
                }

                // Update cart count
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }

                // Show notification
                showNotification(data.message || 'Sản phẩm đã được thêm vào giỏ hàng!', 'success');
            } else {
                // Handle failure
                resetButton(button, originalContent);
                showNotification(data.message || 'Có lỗi xảy ra', 'error');
            }
        })
        .catch(error => {
            console.error('Add to cart error:', error);
            resetButton(button, originalContent);

            if (error.message.includes('419')) {
                showNotification('Phiên làm việc đã hết hạn. Vui lòng tải lại trang.', 'error');
            } else if (error.message.includes('422')) {
                showNotification('Dữ liệu không hợp lệ. Vui lòng thử lại.', 'error');
            } else if (error.message.includes('500')) {
                showNotification('Lỗi máy chủ. Vui lòng thử lại sau.', 'error');
            } else {
                showNotification('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng', 'error');
            }
        });
}

// Helper function to reset button state
function resetButton(button, originalContent) {
    if (button && originalContent) {
        button.innerHTML = originalContent;
        button.disabled = false;
    }
}

// Update cart count in header
function updateCartCount() {
    fetch('/cart/api/count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count || 0;
            }

            const cartTotalElement = document.getElementById('cart-total');
            if (cartTotalElement) {
                cartTotalElement.textContent = data.total || '0đ';
            }
        })
        .catch(error => console.log('Error updating cart count:', error));
}

// Show notification
function showNotification(message, type = 'info') {
    // Check if a notification function exists in parent scope
    if (typeof window.showNotification === 'function') {
        window.showNotification(message, type);
        return;
    }

    // Fallback notification system
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
        }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Initialize cart functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Update cart count on page load
    updateCartCount();
});
