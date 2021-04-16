<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Route::get('/a-propos', function () {
    $name = 'Valentina';

    return view('about', [
        'name' => $name,
        'bibis' => [1, 2, 3, 4]
    ]);
});

route::get('/hello/{name}', function ($name) {
    return "<h1>Hello $name</h1>";
});

Route::get('/nos-annonces', [PropertyController::class, 'index']);

Route::get('/annonce/{id}', [PropertyController::class, 'show'])->whereNumber('id');

Route::get('/annonce/creer', [PropertyController::class, 'create']);

Route::post('/annonce/creer', [PropertyController::class, 'store']);

Route::get('/annonce/editer/{id}', [PropertyController::class, 'edit']);

Route::put('/annonce/editer/{id}', [PropertyController::class, 'update']);

Route::delete('/annonce/{id}', [PropertyController::class, 'destroy']);