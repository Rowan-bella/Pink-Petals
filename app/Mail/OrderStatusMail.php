<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf; 
class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pink Petals - Order #' . $this->order->id . ' Status Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order_status', 
            with: [
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
    
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $this->order]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Invoice-#' . $this->order->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}