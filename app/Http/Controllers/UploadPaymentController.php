<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\UploadPaymentFile\StoreUploadPaymentFileUseCase;

class UploadPaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly StoreUploadPaymentFileUseCase $storeUploadPaymentFileUseCase){}

    public function store(Request $request) {
        return $this->storeUploadPaymentFileUseCase->execute($request);
    }
}
