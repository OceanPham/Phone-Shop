<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChatbotController extends Controller
{
    private $aiAssistantUrl;
    private $timeout;

    public function __construct()
    {
        $this->aiAssistantUrl = config('ai_assistant.url', 'http://localhost:8000');
        $this->timeout = config('ai_assistant.timeout', 30);
    }

    /**
     * Handle chat requests from the chatbot
     */
    public function chat(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'session_id' => 'required|string',
                'question' => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid request data',
                    'errors' => $validator->errors()
                ], 400);
            }

            $sessionId = $request->input('session_id');
            $question = $request->input('question');

            // Log the chat request
            Log::info('Chatbot: Received chat request', [
                'session_id' => $sessionId,
                'question' => $question,
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Send request to AI Assistant
            $response = $this->sendToAIAssistant($sessionId, $question);

            if ($response['success']) {
                return response()->json([
                    'status' => 'ok',
                    'answer' => $response['answer'],
                    'session_id' => $sessionId,
                    'timestamp' => now()->toISOString()
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $response['error'] ?? 'Failed to get response from AI Assistant',
                    'session_id' => $sessionId
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot: Error processing chat request', [
                'error' => $e->getMessage(),
                'session_id' => $request->input('session_id'),
                'question' => $request->input('question')
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'session_id' => $request->input('session_id')
            ], 500);
        }
    }

    /**
     * Send request to AI Assistant API
     */
    private function sendToAIAssistant(string $sessionId, string $question): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->aiAssistantUrl . '/chat', [
                    'session_id' => $sessionId,
                    'question' => $question
                ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('Chatbot: AI Assistant response received', [
                    'session_id' => $sessionId,
                    'status' => $data['status'] ?? 'unknown',
                    'response_time' => $response->handlerStats()['total_time'] ?? 0
                ]);

                return [
                    'success' => true,
                    'answer' => $data['answer'] ?? 'Xin lỗi, tôi không thể xử lý câu hỏi của bạn.',
                    'data' => $data
                ];
            } else {
                Log::warning('Chatbot: AI Assistant API error', [
                    'session_id' => $sessionId,
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'AI Assistant service error: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Chatbot: Error calling AI Assistant API', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
                'url' => $this->aiAssistantUrl . '/chat'
            ]);

            return [
                'success' => false,
                'error' => 'Connection error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Health check for chatbot service
     */
    public function health()
    {
        try {
            $response = Http::timeout(10)->get($this->aiAssistantUrl . '/health');

            return response()->json([
                'status' => 'ok',
                'ai_assistant_healthy' => $response->successful(),
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'ai_assistant_healthy' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 503);
        }
    }
}
