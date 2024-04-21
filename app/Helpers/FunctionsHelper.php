<?php
use Intervention\Image\Facades\Image as ImageResize;

class FunctionHelpers {

    public static function formatDateTimeToView($data) {
        if($data){
            $date = new DateTime($data);
            return $date->format('d/m/Y H:i:s');
        }else{
            return null;
        }
    }

    public static function formatDateToView($data) {
        if($data){
            $date = new DateTime($data);
            return $date->format('d/m/Y');
        }else{
            return null;
        }
    }

    public static function formatMoney($data) {
        return self::formatMoneyBRL($data);
    }

    public static function formatMoneyBRL($data) {
        return number_format($data, 2, ',', '.');
    }

    public static function formatMoneyDB($data) {
        return str_replace(',','.',str_replace('.','', $data));
    }

    public static function uploadFile($request, $name, $path) {
        $image = $request->file($name);
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = storage_path($path);
        $image->move($destinationPath, $name);
        return $path.'/'.$name;
    }

    public static function uploadFileSingle($file, $path) {
        $name = time().'.'.$file->getClientOriginalExtension();
        $destinationPath = storage_path($path);
        $file->move($destinationPath, $name);
        return $path.'/'.$name;
    }
}