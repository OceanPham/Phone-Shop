<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Assistant Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the AI Assistant service
    | that handles vector database updates for product information.
    |
    */

    'url' => env('AI_ASSISTANT_URL', 'http://localhost:8000'),

    'api_key' => env('AI_ASSISTANT_API_KEY'),

    'timeout' => env('AI_ASSISTANT_TIMEOUT', 30),

    'endpoints' => [
        'update_product' => '/put-item',
        'delete_product' => '/delete-item',
        'sync_products' => '/sync-products',
    ],

];
