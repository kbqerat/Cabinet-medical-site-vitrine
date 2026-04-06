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
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);border-radius:20px 20px 0 0;padding:32px 36px;text-align:center;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom:16px;">
                                        <div style="display:inline-block;background:rgba(255,255,255,0.15);border-radius:14px;padding:12px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_plus.svg/200px-Blue_plus.svg.png"
                                                 width="32" height="32" alt="+"
                                                 style="display:block;filter:brightness(0) invert(1);">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <p style="margin:0;font-size:22px;font-weight:800;color:#ffffff;letter-spacing:-0.3px;">MediAssist</p>
                                        <p style="margin:4px 0 0;font-size:13px;color:rgba(255,255,255,0.7);">Nouveau message depuis le site</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background:#ffffff;padding:36px;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;">

                            {{-- Badge --}}
                            <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:50px;padding:5px 14px;">
                                        <span style="font-size:12px;font-weight:700;color:#2563eb;text-transform:uppercase;letter-spacing:0.05em;">📩 Message reçu</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 24px;font-size:16px;color:#1e293b;line-height:1.6;">
                                Bonjour,<br>
                                Vous avez reçu un nouveau message via le widget de contact de votre site <strong>MediAssist</strong>.
                            </p>

                            {{-- Infos expéditeur --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
                                        <p style="margin:0;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">Expéditeur</p>
                                        <p style="margin:4px 0 0;font-size:15px;font-weight:700;color:#1e293b;">{{ $senderName }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">Email</p>
                                        <a href="mailto:{{ $senderEmail }}" style="margin:4px 0 0;display:block;font-size:15px;font-weight:600;color:#2563eb;text-decoration:none;">{{ $senderEmail }}</a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Message --}}
                            <p style="margin:0 0 10px;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">Message</p>
                            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #2563eb;border-radius:0 14px 14px 0;padding:18px 20px;margin-bottom:28px;">
                                <p style="margin:0;font-size:15px;color:#334155;line-height:1.7;white-space:pre-wrap;">{{ $senderMessage }}</p>
                            </div>

                            {{-- CTA répondre --}}
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#2563eb,#4f46e5);border-radius:12px;">
                                        <a href="mailto:{{ $senderEmail }}"
                                           style="display:inline-block;padding:13px 28px;font-size:14px;font-weight:700;color:#ffffff;text-decoration:none;letter-spacing:0.01em;">
                                            Répondre à {{ $senderName }} →
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
                                Ce message a été envoyé depuis le widget de contact de
                                <strong style="color:#64748b;">mediassist.ma</strong>
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
