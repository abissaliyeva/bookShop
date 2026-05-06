<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Book $book
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Order Confirmation – ' . $this->book->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order_confirmation');
    }
}