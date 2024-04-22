<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'],function() use ($router) {
    $router->get('/', function () {
        $database = false;
        $pdo = DB::connection()->getPdo();

        if($pdo){
            $database = true;
        }
        return [
            "env"      => env('APP_ENV'),
            "database" => $database,
            "api"      => true
        ];
    });

    $router->post('/upload', 'UploadPaymentController@store');
    $router->get('/payments/{uploadId}', 'PaymentsController@list');

});
