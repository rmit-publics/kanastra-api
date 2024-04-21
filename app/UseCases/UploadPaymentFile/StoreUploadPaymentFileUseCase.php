<?php
namespace App\UseCases\UploadPaymentFile;

use App\Models\FileUpload;
use App\UseCases\ProcessPayment\ProcessFilePaymentUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Class StoreUploadPaymentFileUseCase {

    protected $processFilePaymentUseCase;
    public function __construct(ProcessFilePaymentUseCase $processFilePaymentUseCase) {
        $this->processFilePaymentUseCase = $processFilePaymentUseCase;
    }

    public function execute(Request $request){
        $pathFile = null;
        $validator = Validator::make($request->all(), [
            'file'       => 'required|mimes:txt,csv',
        ]);

        if($validator->fails()) {
            return $validator->messages();
        }

        if ($request->hasFile('file')) {
            $uploadFile = $request->file('file');
            if ($uploadFile->isValid()) {

                if(!$this->validateTemplete($uploadFile)) {
                    return response()->json(['message' => 'Arquivo foi enviado com o formato errado.'], 400);
                }

                $nomeArquivo = $uploadFile->getClientOriginalName();
                $uploadFile->move(storage_path('file'), $nomeArquivo);
                $pathFile = storage_path('file') . '/' . $nomeArquivo;
                $fileUpload = FileUpload::create([
                    'file' => $pathFile
                ]);
                $this->processFilePaymentUseCase->execute($fileUpload);
                return response()->json(['message' => 'Arquivo foi enviado com sucesso, logo ele será processádo.'], 201);
            }
        } else {
            return response()->json(['message' => 'Nenhum arquivo foi enviado.'], 400);
        }
    }

    private function validateTemplete($file) {
        $handle = fopen($file, "r");
        $fileHeader = fgetcsv($handle);
        $header = array("name", "governmentId", "email","debtAmount", "debtDueDate", "debtId") ;
        return $fileHeader === $header;
    }
}
