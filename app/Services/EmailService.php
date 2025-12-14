<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class EmailService
{
    private string $recipientEmail;
    private string $recipientName;
    private string $senderName;

    public function __construct()
    {
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

            Mail::raw($body, function (Message $message) use ($subject) {
                $message->to($this->recipientEmail, $this->recipientName)
                    ->subject($subject);
            });

            Log::info('Email sent successfully', [
                'to' => $this->recipientEmail,
            ]);

            return [
                'success' => true,
                'message' => 'Message sent successfully!',
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

