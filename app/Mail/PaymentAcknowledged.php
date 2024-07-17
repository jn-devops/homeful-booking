<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class PaymentAcknowledged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($notifiable)
    {
        $this->to($notifiable->email);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Homeful - Payment Acknowledgement',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.paymentacknowledged',
            with: [
                'name' => "Chona Andrade",
                'code' => "JN-123456",
                'mobile'=> "09175852046",
                'brand'=> "Agapeya",
                'tcp' => "2000000",
                'consulting_fee' => "10000",                
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
