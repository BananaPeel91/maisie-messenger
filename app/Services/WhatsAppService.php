<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $apiUrl;
    private string $accessToken;
    private string $phoneNumberId;
    private string $recipientNumber;
    private string $senderName;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->recipientNumber = config('services.whatsapp.recipient_number');
        $this->senderName = config('services.whatsapp.sender_name', 'Maisie');
        $this->apiUrl = "https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages";
    }

    /**
     * Send the love message to mummy
     */
    public function sendLoveMessage(): array
    {
        $message = "I love you mummy 💕\n\n- {$this->senderName}";

        return $this->sendTextMessage($this->recipientNumber, $message);
    }

    /**
     * Send a text message via WhatsApp Cloud API
     */
    private function sendTextMessage(string $to, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $message,
                ],
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'to' => $to,
                    'message_id' => $responseData['messages'][0]['id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Message sent successfully!',
                    'message_id' => $responseData['messages'][0]['id'] ?? null,
                ];
            }

            Log::error('WhatsApp API error', [
                'response' => $responseData,
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => $responseData['error']['message'] ?? 'Failed to send message',
                'error_code' => $responseData['error']['code'] ?? null,
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp service exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while sending the message',
                'error' => $e->getMessage(),
            ];
        }
    }
}

