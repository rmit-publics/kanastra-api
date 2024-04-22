<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Payment\ListPaymentUseCase;
use App\UseCases\UploadPaymentFile\StoreUploadPaymentFileUseCase;

class PaymentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private readonly ListPaymentUseCase $listPaymentUseCase,
        private readonly StoreUploadPaymentFileUseCase $storeUploadPaymentFileUseCase
    ){}

    public function store(Request $request) {
        return $this->storeUploadPaymentFileUseCase->execute($request);
    }

    public function list(int $uploadId) {
        return $this->listPaymentUseCase->execute($uploadId);
    }
}
