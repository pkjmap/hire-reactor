<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Client;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/clients', function () {
    return Client::select('id', 'email')->get();
});

Route::get('/clients/{client}/websites', function (Client $client) {
    return $client->websites()->select('id', 'url')->get();
});