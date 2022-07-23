<?php

use App\Http\Controllers\API\PostControllser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [PostControllser::class, 'index'])->name('index');
Route::post('/store', [PostControllser::class, 'store'])->name('store');
Route::get('/show/{id}', [PostControllser::class, 'show'])->name('show');
Route::put('/update/{id}', [PostControllser::class, 'update'])->name('update');
Route::delete('/destroy/{id}', [PostControllser::class, 'destroy'])->name('destroy');
