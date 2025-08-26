# AI Assistant Integration Setup

## Overview

This document describes the integration between the Laravel phone shop application and the AI Assistant running on port 8000, including both product management and chatbot functionality.

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# AI Assistant Configuration
AI_ASSISTANT_URL=http://localhost:8000
AI_ASSISTANT_TIMEOUT=30
```

### Configuration Files

#### `config/ai_assistant.php`

```php
<?php

return [
    'url' => env('AI_ASSISTANT_URL', 'http://localhost:8000'),
    'api_key' => env('AI_ASSISTANT_API_KEY'),
    'timeout' => env('AI_ASSISTANT_TIMEOUT', 30),
    'endpoints' => [
        'update_product' => '/put-item',
        'delete_product' => '/delete-item',
        'sync_products' => '/sync-products',
        'chat' => '/chat',
        'health' => '/health',
    ],
];
```

## Service Architecture

### AIAssistantService

The integration uses a dedicated service class located at `app/Services/AIAssistantService.php` that handles all communication with the AI Assistant API.

#### Key Methods:

-   `putItem(Product $product)`: Add or update product in vector database
-   `deleteItem(int $productId)`: Remove product from vector database
-   `healthCheck()`: Check if AI Assistant service is running

#### Data Format

The service automatically formats product data according to the AI Assistant API requirements:

```json
{
    "id": "17",
    "name": "iPhone 15 Pro Max",
    "description": "Mô tả sản phẩm",
    "technical_specifications": "Thông số kỹ thuật chi tiết",
    "camera": "Camera thông tin",
    "connectivity_and_network": "Kết nối và mạng",
    "design_and_dimensions": "Thiết kế và kích thước",
    "special_features": "Tính năng đặc biệt",
    "commercial_information": "Thông tin thương mại",
    "inventory_and_sales": "Kho và bán hàng",
    "product_name": "iPhone 15 Pro Max",
    "manufacturer": "Apple",
    "product_line": "iPhone 15",
    "manufacture_date": "2024-09-20",
    "stock_in_date": "2024-12-10",
    "imei_serial_number": "350000000000001",
    "display": "OLED 6.7 inch",
    "cpu_chipset": "Apple A17 Pro",
    "ram": "8GB",
    "internal_storage": "256GB",
    "operating_system": "iOS 17",
    "battery": "4441 mAh",
    "rear_camera": "48MP + 12MP + 12MP",
    "front_camera": "12MP",
    "sim_support": "1 Nano SIM + 1 eSIM",
    "network": "5G",
    "wifi_bluetooth_nfc": "Wi-Fi 6E, Bluetooth 5.3, NFC",
    "ports_connector": "USB-C",
    "dimensions_and_weight": "159.9 x 76.7 x 8.25 mm, 221g",
    "frame_and_back_materials": "Titanium",
    "colors": "Natural Titanium, Blue Titanium, White Titanium, Black Titanium",
    "security": "Face ID",
    "water_dust_resistance_ip": "IP68",
    "charging_support": "USB-C, MagSafe, Qi",
    "wholesale_price": 23992000,
    "retail_price": 29990000,
    "condition": "Mới",
    "manufacturer_warranty": "12 tháng",
    "store_warranty": "Đổi mới 30 ngày nếu lỗi NSX",
    "sku": "IPHONE15PROMAX-17",
    "units_received": 80,
    "in_stock_units": 20,
    "supplier": "Apple Việt Nam (Hotline: 1800-1127)"
}
```

## Integration Points

### ProductController Integration

The `ProductController` automatically calls the AI Assistant service when products are created, updated, or deleted:

```php
// In store method (create)
$aiService = new AIAssistantService();
$aiService->putItem($product);

// In update method (update)
$aiService = new AIAssistantService();
$aiService->putItem($product);

// In destroy method (delete)
$aiService = new AIAssistantService();
$aiService->deleteItem($productId);
```

## Chatbot Integration

### ChatbotController

The chatbot functionality is handled by `app/Http/Controllers/ChatbotController.php` which provides:

-   **Chat API**: Handles user questions and forwards them to AI Assistant
-   **Health Check**: Monitors AI Assistant service status
-   **Session Management**: Maintains conversation context

### Chatbot Component

A beautiful, user-friendly chatbot popup is available at `resources/views/components/chatbot.blade.php` with features:

-   **Modern UI**: Clean, responsive design with smooth animations
-   **Real-time Chat**: Instant messaging with loading indicators
-   **Session Persistence**: Maintains conversation history
-   **Error Handling**: Graceful error messages and fallbacks
-   **Mobile Friendly**: Works perfectly on all devices

### Chatbot Features

#### User Interface

-   Floating chat button in bottom-right corner
-   Expandable chat window with gradient header
-   Message bubbles with different styles for user and assistant
-   Typing indicators and loading animations
-   Auto-scroll to latest messages

#### Functionality

-   Real-time chat with AI Assistant
-   Session-based conversation history
-   Input validation and error handling
-   Keyboard shortcuts (Enter to send)
-   Auto-focus on input field

#### Integration

-   Seamless integration with AI Assistant API
-   CSRF protection for security
-   Comprehensive logging for debugging
-   Graceful fallbacks for connection issues

## API Endpoints

### Health Check

```bash
GET http://localhost:8000/health
```

### Put Item (Create/Update)

```bash
POST http://localhost:8000/put-item
Content-Type: application/json

{
    "id": "17",
    "name": "iPhone 15 Pro Max",
    "description": "Mô tả sản phẩm",
    ...
}
```

### Delete Item

```bash
POST http://localhost:8000/delete-item
Content-Type: application/json

{
    "id": 17
}
```

### Chat API

```bash
POST http://localhost:8000/chat
Content-Type: application/json

{
    "session_id": "session_1234567890_abc123",
    "question": "Tôi muốn mua điện thoại iPhone"
}
```

**Response:**

```json
{
    "status": "ok",
    "answer": "Chào bạn! Tôi có thể giúp bạn tìm hiểu về iPhone...",
    "session_id": "session_1234567890_abc123",
    "timestamp": "2024-01-15T10:30:00.000Z"
}
```

## Setup Instructions

### 1. Start AI Assistant

```bash
cd phone-agent01
uvicorn app.main:app --host 0.0.0.0 --port 8000
```

### 2. Test Connection

```bash
cd phone-shop
php test_ai_service.php
```

### 3. Test Chatbot

```bash
cd phone-shop
php test_chatbot.php
```

### 4. Monitor Logs

```bash
tail -f storage/logs/laravel.log | grep "AI Assistant\|Chatbot"
```

## Usage

### For Users

1. **Access Chatbot**: Click the chat button in the bottom-right corner of any page
2. **Ask Questions**: Type your question about products, specifications, or recommendations
3. **Get Answers**: Receive instant, AI-powered responses with product information
4. **Continue Conversation**: Ask follow-up questions in the same session

### For Developers

1. **Product Management**: CRUD operations automatically sync with AI Assistant
2. **Chatbot Integration**: Use the chatbot component in any view
3. **API Access**: Direct access to chat API for custom implementations
4. **Monitoring**: Comprehensive logging for debugging and analytics

## Troubleshooting

### 1. Connection Errors

-   Check if AI Assistant service is running on port 8000
-   Verify the service is accessible
-   Check firewall settings

### 2. Data Format Errors

-   Ensure product data is properly formatted
-   Check required fields are present
-   Verify JSON structure matches API requirements

### 3. Timeout Errors

-   Increase timeout in configuration
-   Check network connectivity
-   Verify AI Assistant service performance

### 4. Service Security

-   AI Assistant API doesn't require authentication for these endpoints
-   Ensure proper network security
-   Consider adding API key authentication if needed

### 5. Chatbot Issues

-   Check browser console for JavaScript errors
-   Verify CSRF token is present in page
-   Ensure AI Assistant chat endpoint is working
-   Check Laravel logs for detailed error information

## Testing

### Manual Testing

1. Create a new product in admin panel
2. Check Laravel logs for AI Assistant integration
3. Verify data appears in AI Assistant vector database
4. Update product and verify changes are synced
5. Delete product and verify removal from vector database
6. Open chatbot and ask questions about products
7. Test conversation flow and session persistence

### Automated Testing

Run the test scripts to verify all functionality:

```bash
# Test AI Assistant service
php test_ai_service.php

# Test chatbot functionality
php test_chatbot.php
```

## Logging

All AI Assistant and chatbot interactions are logged with detailed information:

-   Success/failure status
-   Request/response data
-   Error messages
-   Product IDs and timestamps
-   Session IDs and user interactions

Check logs at: `storage/logs/laravel.log`

## Security Considerations

### Data Protection

-   All user inputs are validated and sanitized
-   CSRF protection is enabled for all requests
-   Session IDs are generated securely
-   No sensitive data is logged

### API Security

-   Input validation on all endpoints
-   Rate limiting can be implemented
-   Error messages don't expose sensitive information
-   HTTPS should be used in production

### Privacy

-   Chat sessions are temporary and not stored permanently
-   User data is not collected or stored
-   All interactions are anonymous
