<?php
namespace App\UseCases\ProcessPayment;

use App\Models\FileUpload;
use App\Models\Payment;

Class ProcessFilePaymentUseCase {

    public function execute(FileUpload $uploadFile){
        $updateFileProcess = FileUpload::find($uploadFile->id);
        $fileRead = fopen($updateFileProcess->file, 'r');
        $batchSize = 1000;
        $batch = [];

        fgetcsv($fileRead);
        while (($row = fgetcsv($fileRead)) !== false) {
            $editedRow = $this->editRow($updateFileProcess->id, $row);
            $batch[] = $editedRow;
            if (count($batch) === $batchSize) {
                $this->processBatch($batch);
                $batch = [];
            }
        }
        fclose($fileRead);
        $updateFileProcess->save();
    }

    function editRow($fileUploadId, $row) {
        $editedRow = [
            'file_upload_id' => $fileUploadId,
            'name'           => $row[0],
            'government_id'  => $row[1],
            'email'          => $row[2],
            'debt_amount'    => $row[3],
            'debt_due_date'  => $row[4],
            'debt_id'        => $row[5]
        ];

        return $editedRow;
    }
    function processBatch($batch) {
        Payment::insert($batch);
    }


}