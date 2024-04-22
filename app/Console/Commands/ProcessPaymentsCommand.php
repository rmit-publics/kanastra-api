<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Billet\BilletXPTO;
use App\UseCases\Payment\SendPaymentUseCase;


class ProcessPaymentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:processPayments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'processes all payments that are pending or error';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly BilletXPTO $billetXPTO)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sendPaymentUseCase = new SendPaymentUseCase($this->billetXPTO);
        $sendPaymentUseCase->sendPayment();
    }
}
