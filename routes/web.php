<?php

use App\Http\Controllers\Agenda;
use Illuminate\Support\Facades\Route;


Route::get('/',[Agenda::class,'index']);


Route::get('user/detail/{id}',[Agenda::class,'show']);

Route::get('user/edit/{id}',[Agenda::class,'edit']);
Route::post('user/update/',[Agenda::class,'update']);

Route::get('user/delete/{id}',[Agenda::class,'destroy']);
