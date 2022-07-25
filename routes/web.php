<?php

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
    return response('OK', 200);
});

/*

Route::get('/generate-pia', function () {

    echo'okay then';

    return;

});

*/

// Route::get('/7feHraCWK59RMYTm6WeZpECtf7A2ZgtYTP3WqNkhprdGrgj83TxtBLhQZ25QYSHb', function () {
//     return view('emailparse');
// });

Route::get('/pia/{id}', 'PIAController@test');

Route::get('/accounts-export', 'ExportController@test');
