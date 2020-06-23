<?php

use App\Http\Controllers\TodoController;
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
    return view('welcome');
});




Route::group(['middleware' => 'custommiddleware', 'prefix' => 'admin'], function () {
    Route::post('/storePlayerOnTable', 'TodoController@storePlayerOnTable');
    Route::post('/bid', 'TodoController@bid');
    Route::post('/retriveTable', 'TodoController@retriveTable');
    Route::post('/retrivePlayer', 'TodoController@retrivePlayer');
    Route::post('/quitGame', 'TodoController@quitGame');
    Route::post('/isPlaying', 'TodoController@isPlaying');

    Route::post('/pack', 'GameController@pack');
});

// Route::middleware(['custommiddleware'])->group(function () {
//     Route::post('/storePlayerOnTable', 'TodoController@storePlayerOnTable');
// });