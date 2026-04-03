<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/mentions-legales', function () {
    return view('legal.mentions-legales');
});

Route::get('/confidentialite', function () {
    return view('legal.confidentialite');
});

Route::get('/cgu', function () {
    return view('legal.cgu');
});
