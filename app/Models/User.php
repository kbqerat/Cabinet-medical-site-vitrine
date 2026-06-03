<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'phone', 'specialty', 'cabinet_name', 'city', 'bio',
        'photo_url', 'linkedin', 'instagram', 'facebook', 'languages',
        'plan', 'trial_ends_at', 'role', 'verification_status', 'diploma_path',
        'onboarding_done', 'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'trial_ends_at'     => 'datetime',
            'password'          => 'hashed',
            'onboarding_done'   => 'boolean',
            'profile_views'     => 'integer',
        ];
    }

    public function getPhotoUrlAttribute(?string $value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'data:')) return $value; // ancien format base64
        return '/photos/' . $this->id;
    }

    public function sendEmailVerificationNotification(): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        $name = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? '')) ?: 'Docteur';

        Mail::html('
            <div style="font-family:sans-serif;max-width:520px;margin:auto;padding:0;color:#1f2937">

                <div style="background:linear-gradient(135deg,#0a1628,#0d2150,#0f3460);padding:40px 32px;text-align:center;border-radius:16px 16px 0 0">
                    <div style="width:64px;height:64px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px">
                        <span style="font-size:28px">&#9993;</span>
                    </div>
                    <h1 style="color:#fff;font-size:22px;font-weight:800;margin:0 0 6px">Confirmez votre adresse e-mail</h1>
                    <p style="color:rgba(191,219,254,.7);font-size:14px;margin:0">Bienvenue sur MediAssist, Dr. ' . e($name) . '</p>
                </div>

                <div style="background:#fff;padding:32px;border-radius:0 0 16px 16px;border:1px solid #f3f4f6;border-top:none">
                    <p style="color:#374151;font-size:15px;line-height:1.6;margin:0 0 24px">
                        Merci pour votre inscription. Pour activer votre compte et soumettre votre dossier de verification, veuillez confirmer votre adresse e-mail en cliquant sur le bouton ci-dessous.
                    </p>

                    <div style="text-align:center;margin-bottom:28px">
                        <a href="' . $verificationUrl . '"
                           style="display:inline-block;background:linear-gradient(135deg,#0d2150,#0f3460);color:#fff;text-decoration:none;padding:14px 32px;border-radius:10px;font-weight:700;font-size:15px">
                            Confirmer mon adresse e-mail
                        </a>
                    </div>

                    <div style="background:#f8fafc;border-radius:10px;padding:14px 18px;margin-bottom:20px">
                        <p style="color:#6b7280;font-size:12px;margin:0 0 6px;font-weight:600">Le lien ne fonctionne pas ?</p>
                        <p style="color:#9ca3af;font-size:12px;margin:0;word-break:break-all">' . $verificationUrl . '</p>
                    </div>

                    <p style="color:#9ca3af;font-size:12px;margin:0">
                        Ce lien est valable <strong>60 minutes</strong>. Si vous n\'avez pas cree de compte sur MediAssist, ignorez cet e-mail.
                    </p>

                    <hr style="border:none;border-top:1px solid #f3f4f6;margin:24px 0 16px">
                    <p style="color:#d1d5db;font-size:11px;margin:0">MediAssist &middot; Plateforme medicale</p>
                </div>

            </div>
        ', function ($msg) use ($name) {
            $msg->to($this->email, 'Dr. ' . $name)
                ->subject('Confirmez votre adresse e-mail — MediAssist');
        });
    }
}
