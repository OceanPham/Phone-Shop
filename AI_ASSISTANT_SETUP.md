# AI Assistant Integration Setup

## Overview

This integration automatically updates the AI Assistant's vector database whenever products are created, updated, or deleted in the admin panel.

## Configuration

### 1. Environment Variables

Add the following variables to your `.env` file:

```env
# AI Assistant Configuration
AI_ASSISTANT_URL=http://localhost:3000
AI_ASSISTANT_API_KEY=your_ai_assistant_api_key_here
AI_ASSISTANT_TIMEOUT=30
```

### 2. AI Assistant API Endpoints

The system expects the following endpoints to be available on your AI Assistant service:

-   `POST /api/update-product` - Update product information in vector database
-   `POST /api/delete-product` - Remove product from vector database
-   `POST /api/sync-products` - Sync all products (optional)

### 3. API Request Format

#### Update Product Request

```json
{
    "product": {
        "id": 1,
        "name": "Product Name",
        "category_id": 1,
        "price": 1000000,
        "stock": 50,
        "discount": 10,
        "description": "Product description",
        "specifications": "Product specifications",
        "images": ["image1.jpg", "image2.jpg"],
        "promote": 1,
        "special": 0,
        "views": 100,
        "updated_at": "2025-01-27T10:30:00.000000Z"
    },
    "action": "update",
    "timestamp": "2025-01-27T10:30:00.000000Z"
}
```

#### Delete Product Request

```json
{
    "product_id": 1,
    "action": "delete",
    "timestamp": "2025-01-27T10:30:00.000000Z"
}
```

### 4. Headers

All requests include the following headers:

-   `Authorization: Bearer {AI_ASSISTANT_API_KEY}`
-   `Content-Type: application/json`

## Features

### Automatic Updates

-   **Product Creation**: When a new product is created, it's automatically added to the AI Assistant vector database
-   **Product Updates**: When a product is edited, the AI Assistant vector database is updated with the new information
-   **Product Deletion**: When a product is deleted, it's automatically removed from the AI Assistant vector database

### Error Handling

-   All AI Assistant API calls are wrapped in try-catch blocks
-   Failed requests are logged but don't affect the main product operations
-   Timeout is configurable (default: 30 seconds)

### Logging

The system logs all AI Assistant interactions:

-   Success: `AI Assistant Vector Database updated successfully for product: {id}`
-   Warning: `Failed to update AI Assistant Vector Database for product: {id}. Response: {response}`
-   Error: `Error updating AI Assistant Vector Database for product {id}: {error}`

## Testing

### 1. Test Configuration

```bash
# Check if config is loaded correctly
php artisan tinker
>>> config('ai_assistant.url')
>>> config('ai_assistant.api_key')
```

### 2. Test API Connection

```bash
# Test the AI Assistant API endpoint
curl -X POST http://localhost:3000/api/update-product \
  -H "Authorization: Bearer your_api_key" \
  -H "Content-Type: application/json" \
  -d '{"test": true}'
```

### 3. Monitor Logs

```bash
# Watch Laravel logs for AI Assistant interactions
tail -f storage/logs/laravel.log | grep "AI Assistant"
```

## Troubleshooting

### Common Issues

1. **Connection Timeout**

    - Check if AI Assistant service is running
    - Verify `AI_ASSISTANT_URL` is correct
    - Increase `AI_ASSISTANT_TIMEOUT` if needed

2. **Authentication Errors**

    - Verify `AI_ASSISTANT_API_KEY` is correct
    - Check if the API key has proper permissions

3. **Missing Endpoints**
    - Ensure all required endpoints are implemented on AI Assistant service
    - Check endpoint URLs in `config/ai_assistant.php`

### Debug Mode

To enable detailed logging, add to your `.env`:

```env
LOG_LEVEL=debug
```

## Security Considerations

1. **API Key Protection**

    - Never commit API keys to version control
    - Use environment variables for sensitive data
    - Rotate API keys regularly

2. **Network Security**

    - Use HTTPS for production environments
    - Implement proper firewall rules
    - Consider using VPN for internal services

3. **Rate Limiting**
    - Implement rate limiting on AI Assistant API
    - Monitor API usage and set appropriate limits

## Performance Optimization

1. **Async Processing**

    - Consider implementing queue jobs for AI Assistant updates
    - This prevents blocking the main product operations

2. **Batch Updates**

    - For bulk operations, consider batching AI Assistant updates
    - Reduces API calls and improves performance

3. **Caching**
    - Cache AI Assistant responses when appropriate
    - Implement retry logic for failed requests
