<?php


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get("/datatable-package/styling", function() {
    $content = file_get_contents(__DIR__ . "/../Resources/assets/css/datatable.css");

    $response = Response::make($content);
    $response->header('Content-Type', 'text/css');
    return $response;
});
