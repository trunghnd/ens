<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('generate-pdf', 'PDFController@generate_quote');
Route::post('quote-test', 'PDFController@test');

Route::post('generate-pia', 'PIAController@generatePDF');
Route::post('generate-coc', 'CoCController@generatePDF');

Route::post('sendquote', 'sendquote@send_quote');

Route::post('fileupload', 'fileupload@fileup');

Route::post('hsfiles', 'hsfiles@genfile');

Route::post('accounts-export', 'ExportController@export_deals');
Route::get('accounts-export', 'ExportController@export_deals');

Route::get('healthcheck', function() {
    return response('OK', 200);
});
