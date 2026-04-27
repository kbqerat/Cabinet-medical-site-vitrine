<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Contract\Auth;
use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;

// SSL : chemin local sur Windows, vérification native en production
function httpOptions(): array {
    return app()->environment('local') ? ['verify' => 'C:/php/cacert.pem'] : [];
}

// Firebase credentials : supporte fichier (local) ou JSON string (Vercel)
function firebaseCredentials(): array {
    $json = env('FIREBASE_CREDENTIALS_JSON');
    if ($json) {
        return json_decode($json, true);
    }
    return firebaseCredentials();
}

Route::get('/', function () {
    $planConfig = firestorePlanConfig();
    return view('home', compact('planConfig'));
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

    try {
        saveMessageToFirestore([
            'source'    => 'contact',
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? '',
            'specialty' => $data['specialty'] ?? '',
            'subject'   => $data['subject'] ?? 'Contact général',
            'message'   => $data['message'],
            'created_at'=> now()->toDateTimeString(),
        ]);
    } catch (\Throwable) {}

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
        firebaseCredentials()
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

    // Bloquer l'email admin sur cette route
    if ($data['email'] === env('ADMIN_EMAIL')) {
        return back()->with('error', 'Ce compte est un compte administrateur. Utilisez la connexion admin.')->withInput(['email' => $data['email']]);
    }

    $apiKey = env('FIREBASE_WEB_API_KEY');

    $response = \Illuminate\Support\Facades\Http::withOptions(httpOptions())
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

    // Bloquer l'admin sur la route médecin
    if ($json['email'] === env('ADMIN_EMAIL')) {
        session()->flush();
        return redirect('/login/admin')->with('error', 'Ce compte est un compte administrateur. Utilisez la connexion admin.');
    }

    return redirect('/dashboard');
});

Route::get('/login/admin', function () {
    return view('auth.login-admin');
});

Route::post('/login/admin', function (Request $request) {
    $data = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    // Vérifier que c'est bien l'email admin avant même d'appeler Firebase
    if ($data['email'] !== env('ADMIN_EMAIL')) {
        return back()->with('error', 'Accès non autorisé. Ce portail est réservé aux administrateurs.')->withInput(['email' => $data['email']]);
    }

    $apiKey = env('FIREBASE_WEB_API_KEY');

    $response = \Illuminate\Support\Facades\Http::withOptions(httpOptions())
        ->post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
            'email'             => $data['email'],
            'password'          => $data['password'],
            'returnSecureToken' => true,
        ]);

    if ($response->failed() || isset($response->json()['error'])) {
        $errorCode = $response->json()['error']['message'] ?? 'UNKNOWN';

        $message = match(true) {
            str_contains($errorCode, 'INVALID_LOGIN_CREDENTIALS') => 'Email ou mot de passe incorrect.',
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

    return redirect('/admin/dashboard');
});

Route::middleware('doctor')->group(function () {

    Route::get('/dashboard', function () {
        try { $doctor = firestoreUser(session('firebase_uid')); } catch (\Throwable) { $doctor = []; }
        return view('auth.overview', compact('doctor'));
    });

    Route::get('/dashboard/abonnement', function () {
        try { $doctor = firestoreUser(session('firebase_uid')); } catch (\Throwable) { $doctor = []; }
        $planConfig = firestorePlanConfig();
        return view('auth.abonnement', compact('doctor', 'planConfig'));
    });

    Route::get('/dashboard/profil', function () {
        try { $doctor = firestoreUser(session('firebase_uid')); } catch (\Throwable) { $doctor = []; }
        return view('auth.profil', compact('doctor'));
    });

    Route::post('/dashboard/profil', function (Request $request) {
        $data = $request->validate([
            'first_name'   => 'nullable|string|max:100',
            'last_name'    => 'nullable|string|max:100',
            'phone'        => 'nullable|string|max:30',
            'specialty'    => 'nullable|string|max:100',
            'cabinet_name' => 'nullable|string|max:150',
            'city'         => 'nullable|string|max:100',
        ]);

        $uid   = session('firebase_uid');
        $token = firestoreToken();
        $projectId = 'mediassist-d494a';

        $fields = [];
        foreach ($data as $k => $v) {
            $fields[$k] = ['stringValue' => (string) ($v ?? '')];
        }

        $mask = implode('&', array_map(fn($k) => 'updateMask.fieldPaths=' . urlencode($k), array_keys($fields)));

        \Illuminate\Support\Facades\Http::withToken($token)->patch(
            "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$uid}?{$mask}",
            ['fields' => $fields]
        );

        return back()->with('success', 'Profil mis à jour avec succès.');
    });

    Route::get('/dashboard/parametres', function () {
        try { $doctor = firestoreUser(session('firebase_uid')); } catch (\Throwable) { $doctor = []; }
        return view('auth.parametres', compact('doctor'));
    });

    Route::post('/dashboard/parametres/password', function (Request $request) {
        $data = $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ]);

        $apiKey = env('FIREBASE_WEB_API_KEY');

        $check = \Illuminate\Support\Facades\Http::withOptions(httpOptions())
            ->post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
                'email'             => session('firebase_email'),
                'password'          => $data['current_password'],
                'returnSecureToken' => false,
            ]);

        if ($check->failed() || isset($check->json()['error'])) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        try {
            $auth = app(\Kreait\Firebase\Contract\Auth::class);
            $user = $auth->getUserByEmail(session('firebase_email'));
            $auth->changeUserPassword($user->uid, $data['password']);
            return back()->with('success', 'Mot de passe mis à jour avec succès.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    });

});

// ─── Helpers Firestore ────────────────────────────────────────────────────────
function firestoreUser(string $uid): array
{
    $token    = firestoreToken();
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->get("https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/users/{$uid}");

    $fields = $response->json()['fields'] ?? [];
    $data   = [];
    foreach ($fields as $key => $val) {
        $data[$key] = array_values($val)[0] ?? null;
    }
    return $data;
}

function firestoreToken(): string
{
    $credentials = new \Google\Auth\Credentials\ServiceAccountCredentials(
        'https://www.googleapis.com/auth/datastore',
        firebaseCredentials()
    );
    return $credentials->fetchAuthToken()['access_token'];
}

function firestoreUsers(): array
{
    $token    = firestoreToken();
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->get('https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/users');

    $docs    = $response->json()['documents'] ?? [];
    $doctors = [];

    foreach ($docs as $doc) {
        $fields = $doc['fields'] ?? [];
        $entry  = [];
        foreach ($fields as $key => $val) {
            $entry[$key] = array_values($val)[0] ?? null;
        }
        $trialEndsAt          = isset($entry['trial_ends_at']) ? \Carbon\Carbon::parse($entry['trial_ends_at']) : null;
        $entry['trial_active']  = $trialEndsAt && $trialEndsAt->isFuture();
        $entry['trial_ends_fmt']= $trialEndsAt ? $trialEndsAt->format('d/m/Y') : null;
        $entry['created_at_fmt']= isset($entry['created_at']) ? \Carbon\Carbon::parse($entry['created_at'])->format('d/m/Y') : null;
        $doctors[] = $entry;
    }

    usort($doctors, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

    return $doctors;
}

function firestoreMessages(): array
{
    $token    = firestoreToken();
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->get('https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/messages?orderBy=created_at+desc&pageSize=200');

    $docs     = $response->json()['documents'] ?? [];
    $messages = [];

    foreach ($docs as $doc) {
        $fields = $doc['fields'] ?? [];
        $entry  = ['id' => basename($doc['name'] ?? '')];
        foreach ($fields as $key => $val) {
            $entry[$key] = array_values($val)[0] ?? null;
        }
        $entry['created_at_fmt'] = isset($entry['created_at'])
            ? \Carbon\Carbon::parse($entry['created_at'])->format('d/m/Y H:i')
            : null;
        $messages[] = $entry;
    }

    usort($messages, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

    return $messages;
}

function firestorePlanConfig(): array
{
    $defaults = [
        'starter_price_monthly' => 290,
        'starter_price_annual'  => 232,
        'starter_desc'          => 'Pour les médecins solo qui débutent',
        'starter_features_json' => json_encode([
            ['text' => '1 médecin',           'ok' => true],
            ['text' => "Jusqu'à 300 patients", 'ok' => true],
            ['text' => 'Agenda & RDV',         'ok' => true],
            ['text' => 'Ordonnances PDF',      'ok' => true],
            ['text' => 'Multi-utilisateurs',   'ok' => false],
            ['text' => 'App mobile',           'ok' => false],
            ['text' => 'Support prioritaire',  'ok' => false],
        ]),
        'pro_price_monthly'     => 490,
        'pro_price_annual'      => 392,
        'pro_desc'              => 'Le plus populaire pour les cabinets actifs',
        'pro_features_json'     => json_encode([
            ['text' => '1 à 3 médecins',        'ok' => true],
            ['text' => 'Patients illimités',     'ok' => true],
            ['text' => 'Agenda & RDV avancé',    'ok' => true],
            ['text' => 'Ordonnances & analyses', 'ok' => true],
            ['text' => 'Multi-utilisateurs',     'ok' => true],
            ['text' => 'App mobile incluse',     'ok' => true],
            ['text' => 'Support prioritaire',    'ok' => false],
        ]),
        'licence_price'         => 4900,
        'licence_desc'          => 'Paiement unique, hébergé chez vous',
        'licence_suffix'        => 'MAD · paiement unique',
        'licence_features_json' => json_encode([
            ['text' => '1 cabinet',                    'ok' => true],
            ['text' => 'Installation sur votre serveur','ok' => true],
            ['text' => 'Accès illimité à vie',         'ok' => true],
            ['text' => 'MAJ incluses 1 an',            'ok' => true],
            ['text' => 'Code source fourni',           'ok' => true],
            ['text' => 'App mobile',                   'ok' => false],
            ['text' => 'Hébergement cloud',            'ok' => false],
        ]),
    ];
    try {
        $token    = firestoreToken();
        $response = \Illuminate\Support\Facades\Http::withToken($token)
            ->get('https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/config/plans');
        $fields = $response->json()['fields'] ?? [];
        if (empty($fields)) return $defaults;

        $config = [];
        foreach ($fields as $key => $val) {
            $config[$key] = array_values($val)[0] ?? null;
        }
        return array_merge($defaults, $config);
    } catch (\Throwable) {
        return $defaults;
    }
}

function saveMessageToFirestore(array $data): void
{
    $token = firestoreToken();
    $fields = [];
    foreach ($data as $k => $v) {
        $fields[$k] = ['stringValue' => (string) ($v ?? '')];
    }
    \Illuminate\Support\Facades\Http::withToken($token)
        ->post('https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/messages', [
            'fields' => $fields,
        ]);
}

// ─── Admin ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/dashboard', function () {
        try {
            $doctors      = firestoreUsers();
            $trialCount   = count(array_filter($doctors, fn($d) => $d['trial_active']));
            $starterCount = count(array_filter($doctors, fn($d) => ($d['plan'] ?? 'starter') === 'starter'));

            return view('admin.dashboard', [
                'totalDoctors'  => count($doctors),
                'trialDoctors'  => $trialCount,
                'starterCount'  => $starterCount,
                'messageCount'  => '—',
                'recentDoctors' => array_slice($doctors, 0, 5),
            ]);
        } catch (\Throwable $e) {
            return view('admin.dashboard', [
                'totalDoctors'  => '—', 'trialDoctors' => '—',
                'starterCount'  => '—', 'messageCount' => '—',
                'recentDoctors' => [],
            ]);
        }
    });

    Route::get('/medecins', function () {
        try {
            $doctors      = firestoreUsers();
            $trialCount   = count(array_filter($doctors, fn($d) => $d['trial_active']));
            $starterCount = count(array_filter($doctors, fn($d) => ($d['plan'] ?? 'starter') === 'starter'));
            $proCount     = count(array_filter($doctors, fn($d) => ($d['plan'] ?? '') === 'pro'));

            return view('admin.medecins', compact('doctors', 'trialCount', 'starterCount', 'proCount'));
        } catch (\Throwable $e) {
            return view('admin.medecins', [
                'doctors' => [], 'trialCount' => 0, 'starterCount' => 0, 'proCount' => 0,
            ]);
        }
    })->name('admin.medecins');

    Route::get('/plans', function () {
        try {
            $doctors      = firestoreUsers();
            $trialCount   = count(array_filter($doctors, fn($d) => $d['trial_active']));
            $starterCount = count(array_filter($doctors, fn($d) => ($d['plan'] ?? 'starter') === 'starter'));
            $proCount     = count(array_filter($doctors, fn($d) => ($d['plan'] ?? '') === 'pro'));
            $expiringCount = count(array_filter($doctors, fn($d) =>
                $d['trial_active'] && isset($d['trial_ends_at']) &&
                \Carbon\Carbon::parse($d['trial_ends_at'])->diffInDays(now(), false) >= -3
            ));
            foreach ($doctors as &$d) {
                if (isset($d['trial_ends_at']) && $d['trial_active']) {
                    $d['days_left'] = max(0, (int) now()->diffInDays(\Carbon\Carbon::parse($d['trial_ends_at']), false));
                } else {
                    $d['days_left'] = 0;
                }
            }
            unset($d);
            $planConfig = firestorePlanConfig();
            return view('admin.plans', compact('doctors', 'trialCount', 'starterCount', 'proCount', 'expiringCount', 'planConfig') + ['totalDoctors' => count($doctors)]);
        } catch (\Throwable $e) {
            $planConfig = firestorePlanConfig();
            return view('admin.plans', ['doctors' => [], 'trialCount' => 0, 'starterCount' => 0, 'proCount' => 0, 'expiringCount' => 0, 'totalDoctors' => 0, 'planConfig' => $planConfig]);
        }
    })->name('admin.plans');

    Route::post('/plans/config', function (\Illuminate\Http\Request $request) {
        try {
            $plan = $request->input('plan');
            if (!in_array($plan, ['starter', 'pro', 'licence'])) {
                return response()->json(['ok' => false, 'error' => 'Plan invalide'], 400);
            }

            $token   = firestoreToken();
            $baseUrl = 'https://firestore.googleapis.com/v1/projects/mediassist-d494a/databases/(default)/documents/config/plans';

            $fields = [];

            if ($plan === 'licence') {
                $fields["{$plan}_price"]  = ['integerValue' => (int) $request->input('price', 0)];
                $fields["{$plan}_desc"]   = ['stringValue'  => $request->input('desc', '')];
                $fields["{$plan}_suffix"] = ['stringValue'  => $request->input('suffix', '')];
            } else {
                $fields["{$plan}_price_monthly"] = ['integerValue' => (int) $request->input('price_monthly', 0)];
                $fields["{$plan}_price_annual"]  = ['integerValue' => (int) $request->input('price_annual', 0)];
                $fields["{$plan}_desc"]          = ['stringValue'  => $request->input('desc', '')];
            }

            // features JSON: [{text, ok}, ...]
            $featTexts = $request->input('feature_text', []);
            $featOks   = $request->input('feature_ok', []);
            $features  = [];
            foreach ($featTexts as $i => $text) {
                $text = trim($text);
                if ($text !== '') {
                    $features[] = ['text' => $text, 'ok' => isset($featOks[$i])];
                }
            }
            $fields["{$plan}_features_json"] = ['stringValue' => json_encode($features)];

            $mask = implode('&', array_map(fn($k) => 'updateMask.fieldPaths='.urlencode($k), array_keys($fields)));
            $resp = \Illuminate\Support\Facades\Http::withToken($token)
                ->patch("{$baseUrl}?{$mask}", ['fields' => $fields]);

            if ($resp->failed()) {
                return response()->json(['ok' => false, 'error' => $resp->body()], 500);
            }

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    })->name('admin.plans.config');

    Route::get('/messages', function () {
        try {
            $messages     = firestoreMessages();
            $contactCount = count(array_filter($messages, fn($m) => ($m['source'] ?? '') === 'contact'));
            $widgetCount  = count(array_filter($messages, fn($m) => ($m['source'] ?? '') === 'widget'));
            return view('admin.messages', compact('messages', 'contactCount', 'widgetCount'));
        } catch (\Throwable $e) {
            return view('admin.messages', ['messages' => [], 'contactCount' => 0, 'widgetCount' => 0]);
        }
    })->name('admin.messages');

    Route::get('/parametres', function () {
        $firebaseOk    = false;
        $totalDoctors  = 0;
        try {
            $doctors      = firestoreUsers();
            $totalDoctors = count($doctors);
            $firebaseOk   = true;
        } catch (\Throwable) {}

        return view('admin.parametres', compact('firebaseOk', 'totalDoctors'));
    })->name('admin.parametres');

    Route::post('/parametres/password', function (Request $request, \Kreait\Firebase\Contract\Auth $auth) {
        $data = $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ]);

        $apiKey = env('FIREBASE_WEB_API_KEY');

        // Vérifier l'ancien mot de passe via Firebase REST API
        $check = \Illuminate\Support\Facades\Http::withOptions(httpOptions())
            ->post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
                'email'             => env('ADMIN_EMAIL'),
                'password'          => $data['current_password'],
                'returnSecureToken' => false,
            ]);

        if ($check->failed() || isset($check->json()['error'])) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        try {
            $user = $auth->getUserByEmail(env('ADMIN_EMAIL'));
            $auth->changeUserPassword($user->uid, $data['password']);
            return back()->with('success', 'Mot de passe mis à jour avec succès.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    });

    Route::post('/parametres/cache-clear', function () {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return back()->with('success', 'Cache vidé avec succès.');
    });
});

Route::post('/logout', function (Request $request) {
    $isAdmin = session('firebase_email') === env('ADMIN_EMAIL');
    session()->flush();
    $redirect = $request->input('redirect', $isAdmin ? '/login/admin' : '/login/doctor');
    return redirect($redirect)->with('success', 'Vous avez été déconnecté.');
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

    try {
        saveMessageToFirestore([
            'source'    => 'widget',
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => '',
            'specialty' => '',
            'subject'   => '',
            'message'   => $data['message'],
            'created_at'=> now()->toDateTimeString(),
        ]);
    } catch (\Throwable) {}

    return response()->json(['ok' => true]);
});
