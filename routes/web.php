<?php

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

Route::get('/nos-annonces', function () {
    $properties = DB::select('select * from properties where sold = :sold', [
        'sold' => 0,
    ]);

    $properties = DB::table('properties')
        ->where('sold', 0)->where('sold', '=', 1, 'or')->get();

    return view('properties/index', [
        'properties' => $properties,
    ]);
});

Route::get('/annonce/{id}', function ($id) {
    $property = DB::table('properties')->find($id);

    if (! $property) {
        abort(404);
    }

    return view('properties/show', ['property' => $property]);
})->whereNumber('id');

Route::get('/annonce/creer', function () {
    return view('properties/create');
});

Route::post('/annonce/creer', function (Request $request) {
    $request->validate([
        'title' => 'required|string|unique:properties|min:2',
        'description' => 'required|string|min:15',
        'price' =>'required|integer|gt:0',
    ]);

    DB::table('properties')->insert([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'sold' => $request->filled('sold'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/nos-annonces')->withInput();
});