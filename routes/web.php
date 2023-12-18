<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class)->only(['create', 'store']);
Route::get('/files', [FileController::class, 'browseFiles']);
Route::get('/image/{filename}', [FileController::class, 'openImage']);