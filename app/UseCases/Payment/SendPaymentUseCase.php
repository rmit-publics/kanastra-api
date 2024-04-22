<?php
namespace App\UseCases\Payment;

use Exception;
use App\Models\Payment;
use App\Mail\PaymentBilletCreate;
use Illuminate\Support\Facades\Mail;
use App\Services\Billet\BilletInterface;

Class SendPaymentUseCase {
    protected $createBillet;
    public function __construct(BilletInterface $createBillet) {
        $this->createBillet = $createBillet;
    }

    public function sendPayment() {
        $paymentsToProcess = Payment::whereIn('status', ['W', 'E'])
            ->where('attempts', '<', env('ATTEMPTS_LIMIT' , 10))
            ->get();

        foreach($paymentsToProcess as $currentPayment) {
            $payment = Payment::find($currentPayment->id);
            $attempts = $payment->attempts;
            $attempts++;

            try {
                $response = $this->createBillet->createBillet($currentPayment);
                if($response->status === 'success') {
                    $payment->status = 'F';
                    $payment->error_description = null;
                } else {
                    $payment->status = 'E';
                    $payment->error_description = $response->message;
                }
                $payment->attempts = $attempts;
                $payment->save();

                if($response->status === 'success') {
                    Mail::to($payment->email)->send(new PaymentBilletCreate($payment, $response->url_billet));
                }
            } catch(Exception $e) {
                $payment->status = 'E';
                $payment->error_description = $e->getMessage();
                $payment->attempts = $attempts;
                $payment->save();
                continue;
            }
        }
    }
}