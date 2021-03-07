<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\FileGenerator;

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
Route::group(['middleware' => ['cors', 'json.resp']], function () {
  Route::post('/generate_file', 'App\Http\Controllers\FileGenerator@GenerateFile');
  Route::get('/get_file/{id}', 'App\Http\Controllers\FileGenerator@GetFile');

  Route::patch('/file_name', 'App\Http\Controllers\FileGenerator@EditName');
  Route::patch('/file_price', 'App\Http\Controllers\FileGenerator@EditPrice');
  Route::post('/file_image', 'App\Http\Controllers\FileGenerator@EditImage');  // Laravel PUT method does not work with form-data, used POST instead
  Route::patch('/file_category', 'App\Http\Controllers\FileGenerator@EditCategory');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
