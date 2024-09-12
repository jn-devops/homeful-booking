<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class Approved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($notifiable)
    {
        $this->to($notifiable->email)
            ->attachData(base64_decode('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
'), 'qrcode.png', [
            'mime' => 'image/png',
            ])
            ->withSwiftMessage(function ($message) {
                $message->embedData(base64_decode('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
'), 'qrcode.png', 'image/png');
            });
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Homeful - Loan Application Approval',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.approved',
            with: [
                'name' => "Chona Andrade",
                'code' => "JN-123456",
                'qrCodeBase64'=> base64_encode('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
')
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
