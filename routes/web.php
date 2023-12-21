<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/files', [FileController::class, 'browseFiles']);
Route::get('/image/{filename}', [FileController::class, 'openImage']);



// routes/web.php
Route::view('login', 'auth.login');
Route::view('register', 'user.register');
Route::view('admin', 'admin');
Route::view('orders', 'orders');
Route::view('users', 'users');
Route::view('products', 'products');
