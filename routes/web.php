<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

Route::post('/contact', function (Request $request) {
    $data = $request->validate([
        'name'      => 'required|string|max:100',
        'email'     => 'required|email|max:150',
        'phone'     => 'nullable|string|max:30',
        'specialty' => 'nullable|string|max:100',
        'subject'   => 'nullable|string|max:100',
        'message'   => 'required|string|max:3000',
    ]);

    $html = view('emails.contact-form', [
        'name'      => $data['name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'] ?? null,
        'specialty' => $data['specialty'] ?? null,
        'subject'   => $data['subject'] ?? 'Contact général',
        'message'   => $data['message'],
    ])->render();

    Mail::html($html, function ($mail) use ($data) {
        $mail->to('bk.tarek.48@gmail.com')
             ->replyTo($data['email'], $data['name'])
             ->subject("📋 {$data['subject']} — {$data['name']} · MediAssist");
    });

    return response()->json(['ok' => true]);
});

Route::post('/contact-widget', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'message' => 'required|string|max:2000',
    ]);

    $html = view('emails.contact-widget', [
        'senderName'    => $data['name'],
        'senderEmail'   => $data['email'],
        'senderMessage' => $data['message'],
    ])->render();

    Mail::html($html, function ($mail) use ($data) {
        $mail->to('bk.tarek.48@gmail.com')
             ->replyTo($data['email'], $data['name'])
             ->subject("✉️ Nouveau message de {$data['name']} — MediAssist");
    });

    return response()->json(['ok' => true]);
});
