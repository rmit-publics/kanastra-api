<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Mail\Mailable;

class PaymentBilletCreate extends Mailable
{
    /**
     * Construtor do e-mail.
     *
     * @return void
     */
    private $payment;
    private $url;
    public function __construct(Payment $payment, $url)
    {
        $this->payment = $payment;
        $this->url = $url;
    }

    /**
     * Construa a mensagem.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment.billet',[
            "name"       => $this->payment->name,
            "billet_url" => $this->url,
        ]);
    }
}
