<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Contract\Auth;
use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;

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

Route::get('/inscription', function () {
    return view('auth.register');
});

Route::post('/inscription', function (Request $request, Auth $auth) {
    $data = $request->validate([
        'first_name'   => 'required|string|max:100',
        'last_name'    => 'required|string|max:100',
        'email'        => 'required|email|max:150',
        'phone'        => 'nullable|string|max:30',
        'specialty'    => 'nullable|string|max:100',
        'cabinet_name' => 'nullable|string|max:150',
        'city'         => 'nullable|string|max:100',
        'password'     => 'required|string|min:8|confirmed',
        'cgu'          => 'accepted',
    ]);

    // Créer l'utilisateur dans Firebase Auth
    $userRecord = $auth->createUserWithEmailAndPassword(
        $data['email'],
        $data['password']
    );

    // Envoyer l'email de vérification
    $auth->sendEmailVerificationLink($data['email']);

    // Obtenir un token OAuth via le service account
    $credentials = new ServiceAccountCredentials(
        'https://www.googleapis.com/auth/datastore',
        json_decode(file_get_contents(env('FIREBASE_CREDENTIALS')), true)
    );
    $token = $credentials->fetchAuthToken()['access_token'];

    // Sauvegarder le profil dans Firestore via REST API
    $projectId = 'mediassist-d494a';
    $uid = $userRecord->uid;

    Http::withToken($token)->patch(
        "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$uid}",
        [
            'fields' => [
                'uid'          => ['stringValue' => $uid],
                'first_name'   => ['stringValue' => $data['first_name']],
                'last_name'    => ['stringValue' => $data['last_name']],
                'email'        => ['stringValue' => $data['email']],
                'phone'        => ['stringValue' => $data['phone'] ?? ''],
                'specialty'    => ['stringValue' => $data['specialty'] ?? ''],
                'cabinet_name' => ['stringValue' => $data['cabinet_name'] ?? ''],
                'city'         => ['stringValue' => $data['city'] ?? ''],
                'plan'         => ['stringValue' => 'starter'],
                'trial_ends_at'=> ['stringValue' => now()->addDays(14)->toDateTimeString()],
                'created_at'   => ['stringValue' => now()->toDateTimeString()],
            ]
        ]
    );

    return redirect('/inscription/confirmation');
});

Route::get('/inscription/confirmation', function () {
    return view('auth.confirmation');
});

Route::get('/login/doctor', function () {
    return view('auth.login');
});

Route::post('/login/doctor', function (Request $request) {
    $data = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $apiKey = env('FIREBASE_WEB_API_KEY');

    $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => 'C:/php/cacert.pem'])
        ->post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
            'email'             => $data['email'],
            'password'          => $data['password'],
            'returnSecureToken' => true,
        ]);

    if ($response->failed() || isset($response->json()['error'])) {
        $errorCode = $response->json()['error']['message'] ?? 'UNKNOWN';

        $message = match(true) {
            str_contains($errorCode, 'INVALID_LOGIN_CREDENTIALS') => 'Email ou mot de passe incorrect.',
            str_contains($errorCode, 'EMAIL_NOT_FOUND')           => 'Aucun compte associé à cet email.',
            str_contains($errorCode, 'TOO_MANY_ATTEMPTS')         => 'Trop de tentatives. Réessayez plus tard.',
            default                                                => 'Erreur de connexion. Réessayez.',
        };

        return back()->with('error', $message)->withInput(['email' => $data['email']]);
    }

    $json = $response->json();

    session([
        'firebase_uid'          => $json['localId'],
        'firebase_email'        => $json['email'],
        'firebase_display_name' => $json['displayName'] ?? null,
        'firebase_id_token'     => $json['idToken'],
    ]);

    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    if (!session('firebase_uid')) {
        return redirect('/login/doctor');
    }

    return view('auth.dashboard');
});

Route::post('/logout', function () {
    session()->flush();
    return redirect('/login/doctor')->with('success', 'Vous avez été déconnecté.');
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
