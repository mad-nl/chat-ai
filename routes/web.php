<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/chat', 'App\Http\Controllers\ChatController')->name('chat');
