<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerFeedbackNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $feedback;

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, Feedback $feedback)
    {
        $this->customer = $customer;
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Customer Feedback Received')
            ->view('emails.customer-feedback-notification')
            ->with([
                'customer' => $this->customer,
                'feedback' => $this->feedback,
            ]);
    }
} 