<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\social;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/rregjistroo",[social::class,"rregjistro"]);
Route::get("imazh",[social::class, "img"]);
Route::post("rregg",[social::class,"rregjistrodhena"]);
Route::post("hyrr",[social::class,"hyr1"]);
Route::post("postphoto",[social::class,"post"]);
Route::get("profilimarr",[social::class,"marrprofil"]);
Route::get("editprof",[social::class,"profiledit"]);
Route::post("updateprofil",[social::class,"update"]);
Route::get("profiletmarr1", [social::class,"profiletmarr"]);
Route::post("profilin",[social::class,"profilhapinsert"]);
Route::get("profilprivat",[social::class,"profilprivat"]);
Route::post("profilprivep",[social::class,"shoqeriveprimeprivat"]);
Route::get("profilpublic",[social::class, "profilhapurmarr"]);
Route::post("clickpublic1",[social::class,"clickpublic"]);
Route::get("hompag",[social::class,"Homepage"]);
Route::get("explore",[social::class,"exporenxjerr"]);
Route::post("deletepost1",[social::class,"deletepost"]);
Route::get("chat1",[social::class,"chat"]);
Route::post("sendmessage1",[social::class,"sendmesage"]);