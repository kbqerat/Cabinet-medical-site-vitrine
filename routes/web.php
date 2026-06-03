<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Message;
use App\Models\PlanConfig;

// ─── Pages publiques ──────────────────────────────────────────────────────────

Route::get('/', function () {
    $planConfig = PlanConfig::getOrCreate();
    return view('home', compact('planConfig'));
});

Route::get('/mentions-legales', fn() => view('legal.mentions-legales'));
Route::get('/confidentialite',  fn() => view('legal.confidentialite'));
Route::get('/cgu',              fn() => view('legal.cgu'));

Route::get('/sitemap.xml', function () {
    $doctors = User::where('role', 'doctor')
        ->where('verification_status', 'approved')
        ->orderByDesc('updated_at')
        ->get(['id', 'first_name', 'last_name', 'updated_at']);

    $urls = [];

    // Pages statiques
    foreach ([
        ['loc' => '/',         'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => '/medecins', 'priority' => '0.9', 'changefreq' => 'daily'],
    ] as $page) {
        $urls[] = [
            'loc'        => url($page['loc']),
            'changefreq' => $page['changefreq'],
            'priority'   => $page['priority'],
        ];
    }

    // Vitrines médecins
    foreach ($doctors as $doctor) {
        $urls[] = [
            'loc'        => url('/dr/' . doctorSlug($doctor)),
            'lastmod'    => $doctor->updated_at->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority'   => '0.8',
        ];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
         . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($urls as $url) {
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . e($url['loc']) . '</loc>' . "\n";
        if (isset($url['lastmod']))    $xml .= '    <lastmod>'    . $url['lastmod']    . '</lastmod>'    . "\n";
        if (isset($url['changefreq'])) $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
        if (isset($url['priority']))   $xml .= '    <priority>'   . $url['priority']   . '</priority>'   . "\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
});

Route::get('/photos/{id}', function (int $id) {
    $user    = User::findOrFail($id);
    $rawPath = $user->getRawOriginal('photo_url');
    abort_if(!$rawPath || str_starts_with($rawPath, 'data:'), 404);
    abort_if(!str_starts_with($rawPath, 'photos/'), 403);
    abort_if(!Storage::disk('local')->exists($rawPath), 404);
    $ext  = strtolower(pathinfo($rawPath, PATHINFO_EXTENSION));
    $mime = match($ext) {
        'png'  => 'image/png',
        'webp' => 'image/webp',
        default => 'image/jpeg',
    };
    return response(Storage::disk('local')->get($rawPath), 200, [
        'Content-Type'  => $mime,
        'Cache-Control' => 'public, max-age=86400',
    ]);
});

// ─── Mot de passe oublié ──────────────────────────────────────────────────────

Route::get('/mot-de-passe-oublie', fn() => view('auth.forgot-password'));

Route::post('/mot-de-passe-oublie', function (Request $request) {
    $data = $request->validate(['email' => 'required|email']);

    $user = User::where('email', $data['email'])->first();

    if ($user) {
        $token    = Str::random(64);
        $hashed   = hash('sha256', $token);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $hashed, 'created_at' => now()]
        );

        $resetUrl = url('/reinitialiser-mot-de-passe/' . $token . '?email=' . urlencode($user->email));
        $name     = trim($user->first_name . ' ' . $user->last_name) ?: 'Docteur';

        Mail::html('
            <div style="font-family:sans-serif;max-width:480px;margin:auto;padding:32px 24px;color:#1f2937">
                <div style="margin-bottom:24px">
                    <span style="font-size:18px;font-weight:800;color:#0d2150">MediAssist</span>
                </div>
                <h2 style="font-size:20px;font-weight:700;margin:0 0 8px">Réinitialisation de votre mot de passe</h2>
                <p style="color:#6b7280;margin:0 0 24px">Bonjour ' . e($name) . ',<br><br>
                Nous avons reçu une demande de réinitialisation du mot de passe associé à ce compte.<br>
                Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe :</p>
                <a href="' . $resetUrl . '" style="display:inline-block;background:linear-gradient(135deg,#0d2150,#0f3460);color:#fff;text-decoration:none;padding:12px 28px;border-radius:10px;font-weight:700;font-size:14px">
                    Réinitialiser mon mot de passe
                </a>
                <p style="color:#9ca3af;font-size:12px;margin:24px 0 0">Ce lien est valable 60 minutes. Si vous n\'avez pas fait cette demande, ignorez cet e-mail.</p>
                <hr style="border:none;border-top:1px solid #f3f4f6;margin:24px 0">
                <p style="color:#d1d5db;font-size:11px;margin:0">MediAssist · Plateforme médicale</p>
            </div>
        ', function ($msg) use ($user) {
            $msg->to($user->email)->subject('Réinitialisation de votre mot de passe — MediAssist');
        });
    }

    return back()->with('success', 'Si cette adresse e-mail est associée à un compte, vous recevrez un lien sous quelques minutes.');
})->middleware('throttle:5,15');

Route::get('/reinitialiser-mot-de-passe/{token}', function (string $token, Request $request) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email', ''),
    ]);
});

Route::post('/reinitialiser-mot-de-passe', function (Request $request) {
    $data = $request->validate([
        'token'                 => 'required|string',
        'email'                 => 'required|email',
        'password'              => strongPasswordRules(),
        'password_confirmation' => 'required|string',
    ], strongPasswordMessages());

    $record = DB::table('password_reset_tokens')
        ->where('email', $data['email'])
        ->first();

    if (!$record || !hash_equals($record->token, hash('sha256', $data['token']))) {
        return back()->withErrors(['token' => 'Ce lien est invalide ou a déjà été utilisé.'])->withInput();
    }

    if (now()->diffInMinutes($record->created_at) > 60) {
        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
        return back()->withErrors(['token' => 'Ce lien a expiré. Veuillez en demander un nouveau.'])->withInput();
    }

    $user = User::where('email', $data['email'])->first();
    abort_if(!$user, 404);

    $user->update(['password' => Hash::make($data['password'])]);
    DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

    return redirect('/login/doctor')->with('success', 'Mot de passe réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
})->middleware('throttle:5,15');

Route::get('/medecins', function () {
    $doctors = User::where('role', 'doctor')
        ->where('verification_status', 'approved')
        ->orderBy('last_name')
        ->get(['id', 'first_name', 'last_name', 'specialty', 'city', 'cabinet_name', 'photo_url', 'bio']);

    $specialties = $doctors->pluck('specialty')->filter()->unique()->sort()->values();
    $cities      = $doctors->pluck('city')->filter()->unique()->sort()->values();

    $doctors = $doctors->map(fn($d) => [
        'name'         => 'Dr. ' . $d->first_name . ' ' . $d->last_name,
        'specialty'    => $d->specialty   ?? '',
        'city'         => $d->city        ?? '',
        'cabinet_name' => $d->cabinet_name ?? '',
        'photo_url'    => $d->photo_url   ?? '',
        'initials'     => strtoupper(substr($d->first_name ?? '', 0, 1) . substr($d->last_name ?? '', 0, 1)) ?: '?',
        'slug'         => doctorSlug($d),
    ])->values();

    return view('public.medecins', compact('doctors', 'specialties', 'cities'));
});

// ─── Vitrine publique médecin ─────────────────────────────────────────────────

Route::get('/dr/{slug}', function (string $slug) {
    abort_if(!preg_match('/-(\d+)$/', $slug, $m), 404);
    $id = (int) $m[1];

    $doctor = User::where('role', 'doctor')
        ->where('verification_status', 'approved')
        ->findOrFail($id);

    $canonical = doctorSlug($doctor);
    if ($slug !== $canonical) {
        return redirect('/dr/' . $canonical, 301);
    }

    $phone = preg_replace('/\D/', '', $doctor->phone ?? '');
    if (strlen($phone) === 10 && str_starts_with($phone, '0')) {
        $phone = '212' . substr($phone, 1);
    }
    $whatsappUrl = $phone ? "https://wa.me/{$phone}" : null;

    $doctor->increment('profile_views');

    return view('public.doctor', compact('doctor', 'whatsappUrl', 'slug'));
});

Route::post('/dr/{slug}/contact', function (string $slug, Request $request) {
    abort_if(!preg_match('/-(\d+)$/', $slug, $m), 404);
    $id = (int) $m[1];

    $doctor = User::where('role', 'doctor')
        ->where('verification_status', 'approved')
        ->findOrFail($id);

    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'phone'   => 'nullable|string|max:30',
        'message' => 'required|string|max:2000',
    ], [
        'name.required'    => 'Veuillez indiquer votre nom.',
        'email.required'   => 'Veuillez indiquer votre adresse e-mail.',
        'email.email'      => 'Adresse e-mail invalide.',
        'message.required' => 'Veuillez saisir un message.',
    ]);

    $doctorName = trim($doctor->first_name . ' ' . $doctor->last_name);
    $phone      = $data['phone'] ? "<tr><td style='padding:6px 0;font-size:13px;color:#6b7280;width:90px'>Téléphone</td><td style='padding:6px 0;font-size:14px;font-weight:600;color:#111827'>{$data['phone']}</td></tr>" : '';
    $html = "
        <div style='font-family:sans-serif;max-width:540px;margin:0 auto;color:#1f2937'>
            <div style='background:linear-gradient(135deg,#0d2150,#0f3460);padding:24px 28px;border-radius:12px 12px 0 0'>
                <p style='margin:0 0 4px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:rgba(255,255,255,.45)'>MediAssist · Nouveau message</p>
                <h2 style='color:white;margin:0;font-size:18px;font-weight:700'>Message de {$data['name']}</h2>
                <p style='color:rgba(255,255,255,.5);margin:4px 0 0;font-size:13px'>Via la vitrine de Dr. {$doctorName}</p>
            </div>
            <div style='background:#f9fafb;padding:24px 28px;border:1px solid #e5e7eb;border-top:0;border-radius:0 0 12px 12px'>
                <table style='width:100%;border-collapse:collapse;margin-bottom:20px'>
                    <tr><td style='padding:6px 0;font-size:13px;color:#6b7280;width:90px'>Nom</td><td style='padding:6px 0;font-size:14px;font-weight:600;color:#111827'>{$data['name']}</td></tr>
                    <tr><td style='padding:6px 0;font-size:13px;color:#6b7280'>Email</td><td style='padding:6px 0;font-size:14px;font-weight:600;color:#111827'>{$data['email']}</td></tr>
                    {$phone}
                </table>
                <div style='background:white;border:1px solid #e5e7eb;border-radius:10px;padding:16px'>
                    <p style='font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#9ca3af;margin:0 0 10px'>Message</p>
                    <p style='font-size:14px;color:#374151;line-height:1.7;margin:0;white-space:pre-wrap'>" . htmlspecialchars($data['message']) . "</p>
                </div>
                <p style='margin:16px 0 0;font-size:12px;color:#9ca3af'>Répondez directement à cet email pour contacter le patient.</p>
            </div>
        </div>
    ";

    Mail::html($html, function ($mail) use ($doctor, $data, $doctorName) {
        $mail->to($doctor->email, 'Dr. ' . $doctorName)
             ->replyTo($data['email'], $data['name'])
             ->subject("Message de {$data['name']} — Vitrine MediAssist");
    });

    Message::create([
        'source'    => 'vitrine',
        'doctor_id' => $doctor->id,
        'name'      => $data['name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'] ?? null,
        'subject'   => "Vitrine — Dr. {$doctorName}",
        'message'   => $data['message'],
    ]);

    return back()->with('contact_success', true);
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
        $mail->to(env('ADMIN_CONTACT_EMAIL', 'bk.tarek.48@gmail.com'))
             ->replyTo($data['email'], $data['name'])
             ->subject("📋 {$data['subject']} — {$data['name']} · MediAssist");
    });

    Message::create([
        'source'    => 'contact',
        'name'      => $data['name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'] ?? null,
        'specialty' => $data['specialty'] ?? null,
        'subject'   => $data['subject'] ?? 'Contact général',
        'message'   => $data['message'],
    ]);

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
        $mail->to(env('ADMIN_CONTACT_EMAIL', 'bk.tarek.48@gmail.com'))
             ->replyTo($data['email'], $data['name'])
             ->subject("✉️ Nouveau message de {$data['name']} — MediAssist");
    });

    Message::create([
        'source'  => 'widget',
        'name'    => $data['name'],
        'email'   => $data['email'],
        'message' => $data['message'],
    ]);

    return response()->json(['ok' => true]);
});

// ─── Inscription ──────────────────────────────────────────────────────────────

Route::get('/inscription', fn() => view('auth.register'));

Route::post('/inscription', function (Request $request) {
    $data = $request->validate([
        'first_name'   => 'required|string|max:100',
        'last_name'    => 'required|string|max:100',
        'email'        => 'required|email|max:150|unique:users,email',
        'phone'        => 'nullable|string|max:30',
        'specialty'    => 'nullable|string|max:100',
        'cabinet_name' => 'nullable|string|max:150',
        'city'         => 'nullable|string|max:100',
        'password'     => strongPasswordRules(),
        'cgu'          => 'accepted',
        'bio'          => 'nullable|string|max:1000',
        'photo_base64' => 'nullable|string',
        'linkedin'     => 'nullable|url|max:300',
        'instagram'    => 'nullable|url|max:300',
        'facebook'     => 'nullable|url|max:300',
        'languages'    => 'nullable|string|max:200',
    ], strongPasswordMessages());

    $user = User::create([
        'first_name'    => $data['first_name'],
        'last_name'     => $data['last_name'],
        'email'         => $data['email'],
        'password'      => $data['password'],
        'phone'         => $data['phone'] ?? null,
        'specialty'     => $data['specialty'] ?? null,
        'cabinet_name'  => $data['cabinet_name'] ?? null,
        'city'          => $data['city'] ?? null,
        'bio'           => $data['bio'] ?? null,
        'linkedin'      => $data['linkedin'] ?? null,
        'instagram'     => $data['instagram'] ?? null,
        'facebook'      => $data['facebook'] ?? null,
        'languages'     => $data['languages'] ?? null,
        'plan'          => 'starter',
        'trial_ends_at' => now()->addDays(14),
        'role'          => 'doctor',
    ]);

    if (!empty($data['photo_base64']) && str_starts_with($data['photo_base64'], 'data:image/')) {
        savePhotoFromBase64($user, $data['photo_base64']);
    }

    Auth::login($user);
    $request->session()->regenerate();

    $user->sendEmailVerificationNotification();

    return redirect('/email-verification');
});

// ─── Vérification identité médecin ───────────────────────────────────────────

Route::get('/inscription/verification', function () {
    if (!auth()->check() || auth()->user()->role === 'admin') {
        return redirect('/login/doctor');
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        return redirect('/email-verification');
    }
    if (auth()->user()->verification_status === 'approved') {
        return redirect('/dashboard');
    }
    return view('auth.verification');
});

Route::post('/inscription/verification/upload', function (Request $request) {
    if (!auth()->check() || auth()->user()->role === 'admin') {
        return redirect('/login/doctor');
    }

    $request->validate([
        'diploma' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ], [
        'diploma.required' => 'Veuillez sélectionner un fichier.',
        'diploma.mimes'    => 'Format accepté : PDF, JPG ou PNG.',
        'diploma.max'      => 'Le fichier ne doit pas dépasser 5 Mo.',
    ]);

    $file    = $request->file('diploma');
    $mimeMap = ['application/pdf' => 'pdf', 'image/jpeg' => 'jpg', 'image/png' => 'png'];
    $mime    = $file->getMimeType();
    abort_if(!isset($mimeMap[$mime]), 422, 'Format de fichier non supporté.');
    $path = $file->storeAs('diplomas', auth()->id() . '_' . time() . '.' . $mimeMap[$mime], 'local');

    auth()->user()->update(['diploma_path' => $path]);

    return redirect('/verification/en-attente')->with('success', 'Votre diplôme a bien été soumis. Nous vous contacterons sous peu.');
});

Route::post('/inscription/verification/whatsapp', function () {
    if (!auth()->check() || auth()->user()->role === 'admin') {
        return redirect('/login/doctor');
    }
    return redirect('/verification/en-attente');
});

Route::get('/verification/en-attente', function () {
    if (!auth()->check() || auth()->user()->role === 'admin') {
        return redirect('/login/doctor');
    }
    if (auth()->user()->verification_status === 'approved') {
        return redirect('/dashboard');
    }
    return view('auth.verification-pending');
});

// ─── Connexion médecin ────────────────────────────────────────────────────────

Route::get('/login/doctor', fn() => auth()->check() && auth()->user()->role !== 'admin'
    ? redirect('/dashboard')
    : view('auth.login')
);

Route::post('/login/doctor', function (Request $request) {
    $data = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        return back()->with('error', 'Email ou mot de passe incorrect.')->withInput(['email' => $data['email']]);
    }

    if (auth()->user()->role === 'admin') {
        Auth::logout();
        $request->session()->invalidate();
        return back()->with('error', 'Email ou mot de passe incorrect.')->withInput(['email' => $data['email']]);
    }

    $request->session()->regenerate();

    if (!auth()->user()->hasVerifiedEmail()) {
        return redirect('/email-verification');
    }

    if (auth()->user()->verification_status !== 'approved') {
        return redirect('/verification/en-attente');
    }

    return redirect('/dashboard');
})->middleware('throttle:5,1');

// ─── Connexion admin ──────────────────────────────────────────────────────────

Route::get('/login/admin', fn() => auth()->check() && auth()->user()->role === 'admin'
    ? redirect('/admin/dashboard')
    : view('auth.login-admin')
);

Route::post('/login/admin', function (Request $request) {
    $data = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        return back()->with('error', 'Email ou mot de passe incorrect.')->withInput(['email' => $data['email']]);
    }

    if (auth()->user()->role !== 'admin') {
        Auth::logout();
        $request->session()->invalidate();
        return back()->with('error', 'Email ou mot de passe incorrect.')->withInput(['email' => $data['email']]);
    }

    $request->session()->regenerate();
    return redirect('/admin/dashboard');
})->middleware('throttle:5,1');

// ─── Déconnexion ──────────────────────────────────────────────────────────────

Route::post('/logout', function (Request $request) {
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $redirect = $request->input('redirect', $isAdmin ? '/login/admin' : '/login/doctor');
    return redirect($redirect)->with('success', 'Vous avez été déconnecté.');
});

// ─── Vérification email ───────────────────────────────────────────────────────

Route::get('/email-verification', function () {
    if (!auth()->check()) return redirect('/login/doctor');
    $user = auth()->user();
    if ($user->hasVerifiedEmail()) {
        return $user->verification_status === 'approved'
            ? redirect('/dashboard')
            : redirect('/inscription/verification');
    }
    return view('auth.email-verification');
});

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    $user = auth()->user();
    if ($user->verification_status === 'approved') {
        return redirect('/dashboard')->with('success', 'Adresse e-mail vérifiée avec succès.');
    }
    return redirect('/inscription/verification')->with('success', 'Adresse e-mail confirmée ! Soumettez maintenant votre dossier pour activer votre compte.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Lien de vérification renvoyé. Vérifiez votre boîte e-mail.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ─── Espace médecin ───────────────────────────────────────────────────────────

Route::middleware('doctor')->group(function () {

    Route::get('/dashboard', function () {
        $user        = auth()->user();
        $doctor      = $user->toArray();
        $profileUrl  = '/dr/' . doctorSlug($user);
        $profileViews = $user->profile_views ?? 0;
        $messages    = Message::where('doctor_id', $user->id)
                              ->latest()
                              ->get(['id', 'name', 'email', 'message', 'created_at']);
        $messageCount = $messages->count();
        $recentMessages = $messages->take(3);
        return view('auth.overview', compact('doctor', 'profileUrl', 'profileViews', 'messageCount', 'recentMessages'));
    });

    Route::post('/dashboard/onboarding/done', function () {
        auth()->user()->update(['onboarding_done' => true]);
        return response()->noContent();
    });

    Route::get('/dashboard/abonnement', function () {
        $doctor     = auth()->user()->toArray();
        $planConfig = PlanConfig::getOrCreate();
        return view('auth.abonnement', compact('doctor', 'planConfig'));
    });

    Route::get('/dashboard/profil', function () {
        $doctor = auth()->user()->toArray();
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
            'bio'          => 'nullable|string|max:1000',
            'photo_base64' => 'nullable|string',
            'linkedin'     => 'nullable|url|max:300',
            'instagram'    => 'nullable|url|max:300',
            'facebook'     => 'nullable|url|max:300',
            'languages'    => 'nullable|string|max:200',
        ]);

        $fields = collect(['first_name','last_name','phone','specialty','cabinet_name','city','bio','linkedin','instagram','facebook','languages'])
            ->mapWithKeys(fn($k) => [$k => $data[$k] ?? null])
            ->toArray();

        auth()->user()->update($fields);

        if (!empty($data['photo_base64']) && str_starts_with($data['photo_base64'], 'data:image/')) {
            savePhotoFromBase64(auth()->user(), $data['photo_base64']);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    });

    Route::get('/dashboard/parametres', function () {
        $doctor = auth()->user()->toArray();
        return view('auth.parametres', compact('doctor'));
    });

    Route::post('/dashboard/parametres/email', function (Request $request) {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_email'        => 'required|email|max:150',
        ]);

        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        if (User::where('email', $data['new_email'])->where('id', '!=', auth()->id())->exists()) {
            return back()->with('error', 'Cette adresse e-mail est déjà utilisée par un autre compte.');
        }

        auth()->user()->update([
            'email'             => $data['new_email'],
            'email_verified_at' => null,
        ]);

        auth()->user()->sendEmailVerificationNotification();

        return back()->with('success', "E-mail mis à jour. Un lien de vérification a été envoyé à {$data['new_email']}.");
    });

    Route::post('/dashboard/parametres/password', function (Request $request) {
        $data = $request->validate([
            'current_password'      => 'required|string',
            'password'              => strongPasswordRules(),
            'password_confirmation' => 'required|string',
        ], strongPasswordMessages());

        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        auth()->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    });

    Route::post('/dashboard/parametres/delete', function (Request $request) {
        $data = $request->validate([
            'email_confirm' => 'required|string',
            'password'      => 'required|string',
        ]);

        if ($data['email_confirm'] !== auth()->user()->email) {
            return back()->with('error', "L'adresse e-mail saisie ne correspond pas à votre compte.");
        }

        if (!Hash::check($data['password'], auth()->user()->password)) {
            return back()->with('error', 'Mot de passe incorrect. Suppression annulée.');
        }

        $user = auth()->user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user->delete();

        return redirect('/')->with('success', 'Votre compte a été supprimé définitivement.');
    });

});

// ─── Helpers ─────────────────────────────────────────────────────────────────

function savePhotoFromBase64(User $user, string $base64): void
{
    if (!preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/i', $base64, $m)) return;

    $ext      = strtolower($m[1]) === 'jpeg' ? 'jpg' : strtolower($m[1]);
    $contents = base64_decode(substr($base64, strpos($base64, ',') + 1), true);

    if ($contents === false || strlen($contents) > 5 * 1024 * 1024) return;

    $newPath = 'photos/' . $user->id . '_' . time() . '.' . $ext;

    $old = $user->getRawOriginal('photo_url');
    if ($old && !str_starts_with($old, 'data:') && str_starts_with($old, 'photos/') && Storage::disk('local')->exists($old)) {
        Storage::disk('local')->delete($old);
    }

    Storage::disk('local')->put($newPath, $contents);
    $user->update(['photo_url' => $newPath]);
}

function strongPasswordRules(): array
{
    return ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'];
}

function strongPasswordMessages(): array
{
    return [
        'password.min'   => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.regex' => 'Le mot de passe doit contenir au moins une majuscule (A-Z), une minuscule (a-z) et un chiffre (0-9).',
    ];
}

function doctorSlug(User $doctor): string
{
    return str($doctor->first_name . ' ' . $doctor->last_name)->slug() . '-' . $doctor->id;
}

function doctorsWithMeta(): \Illuminate\Support\Collection
{
    return User::where('role', 'doctor')
        ->orderByDesc('created_at')
        ->get()
        ->map(function (User $d) {
            $arr = $d->toArray();
            $trialEndsAt           = $d->trial_ends_at;
            $arr['trial_active']   = $trialEndsAt && $trialEndsAt->isFuture();
            $arr['trial_ends_fmt'] = $trialEndsAt?->format('d/m/Y');
            $arr['created_at_fmt'] = $d->created_at?->format('d/m/Y');
            $arr['trial_ends_at']  = $trialEndsAt?->toDateTimeString();
            $arr['days_left']      = $trialEndsAt ? max(0, (int) now()->diffInDays($trialEndsAt, false)) : 0;
            return $arr;
        });
}

// ─── Espace admin ─────────────────────────────────────────────────────────────

Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/dashboard', function () {
        $doctors      = doctorsWithMeta();
        $trialCount   = $doctors->filter(fn($d) => $d['trial_active'])->count();
        $starterCount = $doctors->filter(fn($d) => ($d['plan'] ?? 'starter') === 'starter')->count();

        return view('admin.dashboard', [
            'totalDoctors'  => $doctors->count(),
            'trialDoctors'  => $trialCount,
            'starterCount'  => $starterCount,
            'messageCount'  => Message::count(),
            'recentDoctors' => $doctors->take(5)->values()->toArray(),
        ]);
    });

    Route::get('/medecins', function () {
        $doctors      = doctorsWithMeta();
        $trialCount   = $doctors->filter(fn($d) => $d['trial_active'])->count();
        $starterCount = $doctors->filter(fn($d) => ($d['plan'] ?? 'starter') === 'starter')->count();
        $proCount     = $doctors->filter(fn($d) => ($d['plan'] ?? '') === 'pro')->count();
        $pendingCount = $doctors->filter(fn($d) => ($d['verification_status'] ?? 'pending') === 'pending')->count();
        $doctors      = $doctors->values()->toArray();

        return view('admin.medecins', compact('doctors', 'trialCount', 'starterCount', 'proCount', 'pendingCount'));
    })->name('admin.medecins');

    Route::get('/plans', function () {
        $doctors       = doctorsWithMeta();
        $trialCount    = $doctors->filter(fn($d) => $d['trial_active'])->count();
        $starterCount  = $doctors->filter(fn($d) => ($d['plan'] ?? 'starter') === 'starter')->count();
        $proCount      = $doctors->filter(fn($d) => ($d['plan'] ?? '') === 'pro')->count();
        $expiringCount = $doctors->filter(fn($d) =>
            $d['trial_active'] && $d['days_left'] <= 3
        )->count();
        $planConfig    = PlanConfig::getOrCreate();
        $totalDoctors  = $doctors->count();
        $doctors       = $doctors->values()->toArray();

        return view('admin.plans', compact('doctors', 'trialCount', 'starterCount', 'proCount', 'expiringCount', 'planConfig', 'totalDoctors'));
    })->name('admin.plans');

    Route::post('/plans/config', function (Request $request) {
        $plan = $request->input('plan');
        if (!in_array($plan, ['starter', 'pro', 'licence'])) {
            return response()->json(['ok' => false, 'error' => 'Plan invalide'], 400);
        }

        $fields = [];

        if ($plan === 'licence') {
            $fields["{$plan}_price"]  = (int) $request->input('price', 0);
            $fields["{$plan}_desc"]   = $request->input('desc', '');
            $fields["{$plan}_suffix"] = $request->input('suffix', '');
        } else {
            $fields["{$plan}_price_monthly"] = (int) $request->input('price_monthly', 0);
            $fields["{$plan}_price_annual"]  = (int) $request->input('price_annual', 0);
            $fields["{$plan}_desc"]          = $request->input('desc', '');
        }

        $featTexts = $request->input('feature_text', []);
        $featOks   = $request->input('feature_ok', []);
        $features  = [];
        foreach ($featTexts as $i => $text) {
            $text = trim($text);
            if ($text !== '') {
                $features[] = ['text' => $text, 'ok' => isset($featOks[$i])];
            }
        }
        $fields["{$plan}_features_json"] = json_encode($features);

        $config = PlanConfig::first() ?? new PlanConfig(PlanConfig::defaults());
        $config->fill($fields)->save();

        return response()->json(['ok' => true]);
    })->name('admin.plans.config');

    Route::get('/messages', function () {
        $messages = Message::orderByDesc('created_at')->get()->map(function ($m) {
            $arr = $m->toArray();
            $arr['created_at_fmt'] = $m->created_at?->format('d/m/Y H:i');
            return $arr;
        })->toArray();
        $contactCount = count(array_filter($messages, fn($m) => ($m['source'] ?? '') === 'contact'));
        $widgetCount  = count(array_filter($messages, fn($m) => ($m['source'] ?? '') === 'widget'));

        return view('admin.messages', compact('messages', 'contactCount', 'widgetCount'));
    })->name('admin.messages');

    Route::get('/profil', function () {
        $profile = [
            'name'  => trim(auth()->user()->first_name . ' ' . auth()->user()->last_name),
            'phone' => auth()->user()->phone ?? '',
        ];
        return view('admin.profil', compact('profile'));
    })->name('admin.profil');

    Route::post('/profil', function (Request $request) {
        $data = $request->validate([
            'name'  => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
        ]);

        if (!empty($data['name'])) {
            $parts = explode(' ', trim($data['name']), 2);
            auth()->user()->update([
                'first_name' => $parts[0],
                'last_name'  => $parts[1] ?? '',
                'phone'      => $data['phone'] ?? null,
            ]);
        } else {
            auth()->user()->update(['phone' => $data['phone'] ?? null]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    });

    Route::get('/parametres', function () {
        $totalDoctors = User::where('role', 'doctor')->count();
        $profile = [
            'name'  => trim(auth()->user()->first_name . ' ' . auth()->user()->last_name),
            'phone' => auth()->user()->phone ?? '',
        ];
        return view('admin.parametres', compact('totalDoctors', 'profile'));
    })->name('admin.parametres');

    Route::post('/parametres/email', function (Request $request) {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_email'        => 'required|email|max:150',
        ]);

        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        if (User::where('email', $data['new_email'])->where('id', '!=', auth()->id())->exists()) {
            return back()->with('error', 'Cette adresse e-mail est déjà utilisée.');
        }

        auth()->user()->update(['email' => $data['new_email']]);

        return back()->with('success', 'E-mail administrateur mis à jour avec succès.');
    });

    Route::post('/parametres/password', function (Request $request) {
        $data = $request->validate([
            'current_password'      => 'required|string',
            'password'              => strongPasswordRules(),
            'password_confirmation' => 'required|string',
        ], strongPasswordMessages());

        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        auth()->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    });

    Route::post('/parametres/cache-clear', function () {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return back()->with('success', 'Cache vidé avec succès.');
    });

    // ─── Vérifications médecins ───────────────────────────────────────────────

    Route::post('/medecins/{id}/approve', function (int $id) {
        $doctor = User::where('role', 'doctor')->findOrFail($id);
        $doctor->update(['verification_status' => 'approved']);

        $name       = trim($doctor->first_name . ' ' . $doctor->last_name) ?: 'Docteur';
        $dashUrl    = url('/dashboard');
        $profileUrl = url('/dr/' . doctorSlug($doctor));

        Mail::html('
            <div style="font-family:sans-serif;max-width:520px;margin:auto;padding:0;color:#1f2937">

                <div style="background:linear-gradient(135deg,#0a1628,#0d2150,#0f3460);padding:40px 32px;text-align:center;border-radius:16px 16px 0 0">
                    <div style="width:64px;height:64px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px">
                        <span style="font-size:28px">✓</span>
                    </div>
                    <h1 style="color:#fff;font-size:22px;font-weight:800;margin:0 0 6px">Compte vérifié !</h1>
                    <p style="color:rgba(191,219,254,.7);font-size:14px;margin:0">Bienvenue sur MediAssist, Dr. ' . e($name) . '</p>
                </div>

                <div style="background:#fff;padding:32px;border-radius:0 0 16px 16px;border:1px solid #f3f4f6;border-top:none">
                    <p style="color:#374151;font-size:15px;line-height:1.6;margin:0 0 20px">
                        Bonne nouvelle ! Notre équipe a examiné votre dossier et votre identité a été <strong style="color:#059669">vérifiée avec succès</strong>.<br><br>
                        Vous avez maintenant accès à votre espace médecin et votre vitrine publique est en ligne.
                    </p>

                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px 20px;margin-bottom:24px">
                        <p style="color:#166534;font-size:13px;font-weight:600;margin:0 0 4px">Ce que vous pouvez faire maintenant :</p>
                        <ul style="color:#15803d;font-size:13px;margin:0;padding-left:18px;line-height:2">
                            <li>Compléter votre profil (photo, bio, spécialité)</li>
                            <li>Partager votre vitrine publique à vos patients</li>
                            <li>Recevoir des messages de contact via votre page</li>
                        </ul>
                    </div>

                    <div style="display:flex;gap:12px;flex-wrap:wrap">
                        <a href="' . $dashUrl . '" style="display:inline-block;background:linear-gradient(135deg,#0d2150,#0f3460);color:#fff;text-decoration:none;padding:12px 24px;border-radius:10px;font-weight:700;font-size:14px">
                            Accéder à mon espace
                        </a>
                        <a href="' . $profileUrl . '" style="display:inline-block;background:#f8fafc;color:#0d2150;text-decoration:none;padding:12px 24px;border-radius:10px;font-weight:600;font-size:14px;border:1px solid #e2e8f0">
                            Voir ma vitrine →
                        </a>
                    </div>

                    <hr style="border:none;border-top:1px solid #f3f4f6;margin:28px 0 16px">
                    <p style="color:#9ca3af;font-size:12px;margin:0">
                        MediAssist · Si vous avez des questions, répondez à cet e-mail ou contactez-nous sur WhatsApp.
                    </p>
                </div>

            </div>
        ', function ($msg) use ($doctor, $name) {
            $msg->to($doctor->email, 'Dr. ' . $name)
                ->subject('Votre compte MediAssist est vérifié ✓');
        });

        return back()->with('success', "Dr. {$doctor->first_name} {$doctor->last_name} approuvé — e-mail envoyé.");
    })->name('admin.medecins.approve');

    Route::post('/medecins/{id}/reject', function (int $id) {
        $doctor = User::where('role', 'doctor')->findOrFail($id);
        $doctor->update(['verification_status' => 'rejected']);

        $name    = trim($doctor->first_name . ' ' . $doctor->last_name) ?: 'Docteur';
        $retryUrl = url('/inscription/verification');

        Mail::html('
            <div style="font-family:sans-serif;max-width:520px;margin:auto;padding:0;color:#1f2937">

                <div style="background:linear-gradient(135deg,#0a1628,#0d2150,#0f3460);padding:40px 32px;text-align:center;border-radius:16px 16px 0 0">
                    <div style="width:64px;height:64px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px">
                        <span style="font-size:28px">✗</span>
                    </div>
                    <h1 style="color:#fff;font-size:22px;font-weight:800;margin:0 0 6px">Vérification non aboutie</h1>
                    <p style="color:rgba(191,219,254,.7);font-size:14px;margin:0">Dr. ' . e($name) . '</p>
                </div>

                <div style="background:#fff;padding:32px;border-radius:0 0 16px 16px;border:1px solid #f3f4f6;border-top:none">
                    <p style="color:#374151;font-size:15px;line-height:1.6;margin:0 0 20px">
                        Après examen de votre dossier, nous n\'avons pas pu valider votre identité en l\'état.<br><br>
                        Cela peut arriver si le document soumis était illisible, expiré, ou ne correspondait pas aux informations du compte.
                    </p>

                    <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:16px 20px;margin-bottom:24px">
                        <p style="color:#9a3412;font-size:13px;font-weight:600;margin:0 0 4px">Que faire ?</p>
                        <ul style="color:#c2410c;font-size:13px;margin:0;padding-left:18px;line-height:2">
                            <li>Soumettre un document plus lisible</li>
                            <li>Vérifier que le nom correspond à votre compte</li>
                            <li>Nous contacter sur WhatsApp pour toute question</li>
                        </ul>
                    </div>

                    <a href="' . $retryUrl . '" style="display:inline-block;background:linear-gradient(135deg,#0d2150,#0f3460);color:#fff;text-decoration:none;padding:12px 24px;border-radius:10px;font-weight:700;font-size:14px">
                        Soumettre à nouveau
                    </a>

                    <hr style="border:none;border-top:1px solid #f3f4f6;margin:28px 0 16px">
                    <p style="color:#9ca3af;font-size:12px;margin:0">
                        MediAssist · Une question ? Contactez-nous sur <a href="https://wa.me/212721667521" style="color:#9ca3af">WhatsApp</a>.
                    </p>
                </div>

            </div>
        ', function ($msg) use ($doctor, $name) {
            $msg->to($doctor->email, 'Dr. ' . $name)
                ->subject('Mise à jour de votre vérification MediAssist');
        });

        return back()->with('success', "Dr. {$doctor->first_name} {$doctor->last_name} refusé — e-mail envoyé.");
    })->name('admin.medecins.reject');

    Route::get('/medecins/{id}/diploma', function (int $id) {
        $doctor = User::where('role', 'doctor')->findOrFail($id);
        if (!$doctor->diploma_path) abort(404);
        if (!str_starts_with($doctor->diploma_path, 'diplomas/')) abort(403);
        if (!Storage::disk('local')->exists($doctor->diploma_path)) abort(404);
        $ext = strtolower(pathinfo($doctor->diploma_path, PATHINFO_EXTENSION));
        return Storage::disk('local')->download(
            $doctor->diploma_path,
            'diplome_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $doctor->last_name) . '.' . $ext
        );
    })->name('admin.medecins.diploma');

});
