<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailService
{
    private string $apiKey;
    private string $fromEmail;
    private string $fromName;
    private string $recipientEmail;
    private string $recipientName;
    private string $senderName;

    public function __construct()
    {
        $this->apiKey = config('services.resend.api_key');
        $this->fromEmail = config('services.resend.from_email');
        $this->fromName = config('services.resend.from_name', 'Maisie');
        $this->recipientEmail = config('services.maisie.recipient_email');
        $this->recipientName = config('services.maisie.recipient_name', 'Mummy');
        $this->senderName = config('services.maisie.sender_name', 'Maisie');
    }

    /**
     * Send the love message to mummy
     */
    public function sendLoveMessage(): array
    {
        try {
            $subject = "A message from {$this->senderName} 💕";
            $body = "I love you mummy 💕\n\n- {$this->senderName}";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post('https://api.resend.com/emails', [
                'from' => "{$this->fromName} <{$this->fromEmail}>",
                'to' => [$this->recipientEmail],
                'subject' => $subject,
                'text' => $body,
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                Log::info('Email sent successfully via Resend', [
                    'to' => $this->recipientEmail,
                    'id' => $responseData['id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Message sent successfully!',
                    'email_id' => $responseData['id'] ?? null,
                ];
            }

            Log::error('Resend API error', [
                'response' => $responseData,
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Failed to send email',
            ];

        } catch (\Exception $e) {
            Log::error('Email service exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while sending the email',
                'error' => $e->getMessage(),
            ];
        }
    }
}
