<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function __construct(
        private WhatsAppService $whatsAppService
    ) {}

    /**
     * Send the love message to mummy
     */
    public function sendLove(): JsonResponse
    {
        $result = $this->whatsAppService->sendLoveMessage();

        $statusCode = $result['success'] ? 200 : 500;

        return response()->json($result, $statusCode);
    }
}

