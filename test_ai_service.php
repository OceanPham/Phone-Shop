<?php

require_once 'vendor/autoload.php';

use App\Services\AIAssistantService;
use App\Models\Product;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== AI Assistant Service Test ===\n\n";

// Create service instance
$aiService = new AIAssistantService();

// Test 1: Health Check
echo "1. Testing Health Check...\n";
if ($aiService->healthCheck()) {
    echo "✅ AI Assistant service is healthy\n";
} else {
    echo "❌ AI Assistant service is not responding\n";
    echo "Make sure your AI Assistant is running on port 8000\n";
    echo "Command: uvicorn app.main:app --host 0.0.0.0 --port 8000\n\n";
    exit(1);
}

// Test 2: Get a sample product
echo "\n2. Getting sample product...\n";
$product = Product::with('category')->first();

if (!$product) {
    echo "❌ No products found in database\n";
    exit(1);
}

echo "✅ Found product: {$product->tensp} (ID: {$product->masanpham})\n";

// Test 3: Put Item (Create/Update)
echo "\n3. Testing Put Item...\n";
if ($aiService->putItem($product)) {
    echo "✅ Product added/updated successfully in AI Assistant\n";
} else {
    echo "❌ Failed to add/update product in AI Assistant\n";
}

// Test 4: Delete Item
echo "\n4. Testing Delete Item...\n";
if ($aiService->deleteItem($product->masanpham)) {
    echo "✅ Product deleted successfully from AI Assistant\n";
} else {
    echo "❌ Failed to delete product from AI Assistant\n";
}

echo "\n=== Test Complete ===\n";
echo "Check Laravel logs for detailed information:\n";
echo "tail -f storage/logs/laravel.log | grep 'AI Assistant'\n";
