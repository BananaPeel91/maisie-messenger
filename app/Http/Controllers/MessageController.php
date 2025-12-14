<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function __construct(
        private EmailService $emailService
    ) {}

    /**
     * Send the love message to mummy
     */
    public function sendLove(): JsonResponse
    {
        $result = $this->emailService->sendLoveMessage();

        $statusCode = $result['success'] ? 200 : 500;

        return response()->json($result, $statusCode);
    }
}
