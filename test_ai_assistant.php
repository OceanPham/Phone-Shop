<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Test AI Assistant Integration
echo "=== AI Assistant Integration Test ===\n";

// Test configuration
$aiUrl = 'http://localhost:8000';
$endpoints = [
    'put_item' => '/put-item',
    'delete_item' => '/delete-item',
    'health' => '/health'
];

// Test 1: Health Check
echo "\n1. Testing Health Check...\n";
try {
    $response = Http::timeout(10)->get($aiUrl . $endpoints['health']);
    if ($response->successful()) {
        echo "✅ Health check passed: " . $response->body() . "\n";
    } else {
        echo "❌ Health check failed: " . $response->status() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Health check error: " . $e->getMessage() . "\n";
}

// Test 2: Put Item (Create/Update Product)
echo "\n2. Testing Put Item...\n";
$testProduct = [
    'id' => 999,
    'name' => 'Test Product - iPhone 15 Pro Max',
    'category_id' => 1,
    'price' => 29990000,
    'stock' => 50,
    'discount' => 10,
    'description' => 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ, camera 48MP, màn hình 6.7 inch Super Retina XDR OLED',
    'specifications' => 'Màn hình: 6.7 inch Super Retina XDR OLED; Chip: A17 Pro; RAM: 8GB; Pin: 4441 mAh; Camera: 48MP + 12MP + 12MP',
    'images' => ['test_image1.jpg', 'test_image2.jpg'],
    'promote' => 1,
    'special' => 0,
    'views' => 100
];

try {
    $response = Http::timeout(30)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post($aiUrl . $endpoints['put_item'], $testProduct);

    if ($response->successful()) {
        echo "✅ Put item successful: " . $response->body() . "\n";
    } else {
        echo "❌ Put item failed: " . $response->status() . " - " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Put item error: " . $e->getMessage() . "\n";
}

// Test 3: Delete Item
echo "\n3. Testing Delete Item...\n";
try {
    $response = Http::timeout(30)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post($aiUrl . $endpoints['delete_item'], [
            'id' => 999
        ]);

    if ($response->successful()) {
        echo "✅ Delete item successful: " . $response->body() . "\n";
    } else {
        echo "❌ Delete item failed: " . $response->status() . " - " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Delete item error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "Make sure your AI Assistant is running on port 8000\n";
echo "Command: uvicorn app.main:app --host 0.0.0.0 --port 8000\n";
