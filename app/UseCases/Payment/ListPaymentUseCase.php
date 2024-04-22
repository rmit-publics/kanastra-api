<?php
namespace App\UseCases\Payment;

use App\Models\Payment;

Class ListPaymentUseCase {

    function execute($uploadId) {
        return Payment::where('file_upload_id', $uploadId)
            ->paginate(10);
    }

}