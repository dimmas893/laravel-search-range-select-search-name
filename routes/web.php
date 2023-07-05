<?php

use App\Http\Controllers\SearchController;
use App\Models\Product;
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
    (int)$maxPrice = Product::orderBy('price', 'DESC')->first()->price;
    (int)$minPrice = Product::orderBy('price', 'ASC')->first()->price;
    $genders  = Product::select('gender')->groupBy('gender')->get();
    $brands  = Product::select('brand')->groupBy('brand')->get();
    // dd($maxPrice);
    return view('search', compact('maxPrice', 'minPrice', 'genders', 'brands'));
});

Route::get('/search', [SearchController::class, 'search']);
