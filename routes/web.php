<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/move', function () {
    dd(storage_path('/app'.substr('/storage/2022/09/26/33ebc84261bcaa28ffdf3ec93b73db767f84a826.png',8)));

    // \File::copy(
    //     storage_path('app/2022/09/25/1b7c246b3a2af1ea7976b5ade2e2bc815ae711d6.jpg'),
    //     public_path('uploads/1b7c246b3a2af1ea7976b5ade2e2bc815ae711d6.jpg')
    // );
    
});
