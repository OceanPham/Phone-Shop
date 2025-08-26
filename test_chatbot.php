<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Chatbot Test ===\n\n";

// Test configuration
$aiUrl = 'http://localhost:8000';
$sessionId = 'test_session_' . time();

echo "1. Testing AI Assistant Health Check...\n";
try {
    $response = file_get_contents($aiUrl . '/health');
    $healthData = json_decode($response, true);

    if ($healthData && isset($healthData['status'])) {
        echo "✅ AI Assistant is healthy: " . $healthData['status'] . "\n";
    } else {
        echo "❌ AI Assistant health check failed\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "❌ Cannot connect to AI Assistant: " . $e->getMessage() . "\n";
    echo "Make sure your AI Assistant is running on port 8000\n";
    echo "Command: uvicorn app.main:app --host 0.0.0.0 --port 8000\n\n";
    exit(1);
}

echo "\n2. Testing Chat API...\n";

// Test questions
$testQuestions = [
    "Xin chào, bạn có thể giúp tôi tìm điện thoại iPhone không?",
    "Tôi muốn mua điện thoại có camera tốt, giá dưới 20 triệu",
    "So sánh iPhone 15 và Samsung Galaxy S24",
    "Điện thoại nào có pin trâu nhất?",
    "Tôi cần điện thoại chơi game tốt"
];

foreach ($testQuestions as $index => $question) {
    echo "\n--- Test " . ($index + 1) . " ---\n";
    echo "Question: " . $question . "\n";

    try {
        // Prepare request data
        $data = [
            'session_id' => $sessionId,
            'question' => $question
        ];

        // Create context
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                'content' => json_encode($data)
            ]
        ]);

        // Send request
        $response = file_get_contents($aiUrl . '/chat', false, $context);
        $responseData = json_decode($response, true);

        if ($responseData && isset($responseData['status'])) {
            if ($responseData['status'] === 'ok') {
                echo "✅ Response received successfully\n";
                echo "Answer: " . substr($responseData['answer'], 0, 200) . "...\n";
            } else {
                echo "❌ Error response: " . ($responseData['message'] ?? 'Unknown error') . "\n";
            }
        } else {
            echo "❌ Invalid response format\n";
            echo "Raw response: " . $response . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }

    // Small delay between requests
    sleep(1);
}

echo "\n=== Test Complete ===\n";
echo "Session ID used: " . $sessionId . "\n";
echo "Check Laravel logs for detailed information:\n";
echo "tail -f storage/logs/laravel.log | grep 'Chatbot'\n";
