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

    'url' => env('AI_ASSISTANT_URL', 'http://localhost:3000'),

    'api_key' => env('AI_ASSISTANT_API_KEY'),

    'timeout' => env('AI_ASSISTANT_TIMEOUT', 30),

    'endpoints' => [
        'update_product' => '/api/update-product',
        'delete_product' => '/api/delete-product',
        'sync_products' => '/api/sync-products',
    ],

];
