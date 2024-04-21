<?php
namespace App\Services\Billet;

class BilletXPTO implements BilletInterface {

    public function createBillet($data) : object
    {
        $response = $this->simulateCreateBillet();
        return (object) $response;
    }

    private function simulateCreateBillet() {
        $numero = rand();
        if($numero % 2 == 0) {
            return [
                "status"     => "success",
                "url_billet" => "https://www.google.com/",
                "message"    => "Billet create"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Erro random to test"
            ];
        }
    }
}
