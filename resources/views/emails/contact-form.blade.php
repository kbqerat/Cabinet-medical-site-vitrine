<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message — MediAssist</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);border-radius:20px 20px 0 0;padding:32px 36px;text-align:center;">
                            <p style="margin:0 0 6px;font-size:24px;font-weight:800;color:#ffffff;letter-spacing:-0.3px;">MediAssist</p>
                            <p style="margin:0;font-size:13px;color:rgba(255,255,255,0.7);">Nouvelle demande depuis le formulaire de contact</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background:#ffffff;padding:36px;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;">

                            {{-- Badge objet --}}
                            <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:50px;padding:5px 14px;">
                                        <span style="font-size:12px;font-weight:700;color:#2563eb;">📋 {{ $subject }}</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 24px;font-size:15px;color:#1e293b;line-height:1.6;">
                                Vous avez reçu une nouvelle demande via le formulaire de contact de <strong>MediAssist</strong>.
                            </p>

                            {{-- Infos médecin --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:14px 20px;border-bottom:1px solid #e2e8f0;background:#f1f5f9;">
                                        <p style="margin:0;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;">Médecin</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" style="padding:14px 20px;border-bottom:1px solid #e2e8f0;border-right:1px solid #e2e8f0;vertical-align:top;">
                                        <p style="margin:0 0 2px;font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">Nom</p>
                                        <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;">{{ $name }}</p>
                                    </td>
                                    <td width="50%" style="padding:14px 20px;border-bottom:1px solid #e2e8f0;vertical-align:top;">
                                        <p style="margin:0 0 2px;font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">Spécialité</p>
                                        <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;">{{ $specialty ?: '—' }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" style="padding:14px 20px;border-right:1px solid #e2e8f0;vertical-align:top;">
                                        <p style="margin:0 0 2px;font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">Email</p>
                                        <a href="mailto:{{ $email }}" style="margin:0;display:block;font-size:14px;font-weight:600;color:#2563eb;text-decoration:none;">{{ $email }}</a>
                                    </td>
                                    <td width="50%" style="padding:14px 20px;vertical-align:top;">
                                        <p style="margin:0 0 2px;font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">Téléphone</p>
                                        <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;">{{ $phone ?: '—' }}</p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Message --}}
                            <p style="margin:0 0 10px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">Message</p>
                            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #2563eb;border-radius:0 14px 14px 0;padding:18px 20px;margin-bottom:28px;">
                                <p style="margin:0;font-size:15px;color:#334155;line-height:1.7;white-space:pre-wrap;">{{ $message }}</p>
                            </div>

                            {{-- CTA --}}
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);border-radius:12px;">
                                        <a href="mailto:{{ $email }}"
                                           style="display:inline-block;padding:13px 28px;font-size:14px;font-weight:700;color:#ffffff;text-decoration:none;">
                                            Répondre à {{ $name }} →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f8fafc;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 20px 20px;padding:20px 36px;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;">
                                Formulaire de contact — <strong style="color:#64748b;">mediassist.ma</strong>
                            </p>
                            <p style="margin:8px 0 0;font-size:11px;color:#cbd5e1;">© {{ date('Y') }} MediAssist — Tous droits réservés</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
