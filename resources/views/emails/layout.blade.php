<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>ProjetGov</title>
<style>
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Segoe UI',Arial,sans-serif;background:#f0f4f8;color:#374151;}
  .outer{padding:32px 16px;}
  .wrapper{max-width:600px;margin:0 auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.10);}

  /* ── Header ── */
  .email-header{background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 60%,#3b82f6 100%);padding:36px 40px;text-align:center;}
  .email-logo{display:inline-flex;align-items:center;gap:10px;text-decoration:none;}
  .logo-icon{width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;}
  .logo-icon svg{width:22px;height:22px;fill:#fff;}
  .logo-text{font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-.03em;}
  .logo-text span{color:#93c5fd;}
  .header-tagline{margin-top:8px;font-size:.78rem;color:rgba(255,255,255,.6);letter-spacing:.06em;text-transform:uppercase;}

  /* ── Bandeau statut ── */
  .status-band{padding:20px 40px;display:flex;align-items:center;gap:14px;}
  .status-band.green {background:#f0fdf4;border-bottom:1px solid #bbf7d0;}
  .status-band.blue  {background:#eff6ff;border-bottom:1px solid #bfdbfe;}
  .status-band.teal  {background:#f0fdfa;border-bottom:1px solid #99f6e4;}
  .status-band.red   {background:#fef2f2;border-bottom:1px solid #fecaca;}
  .status-icon{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.2rem;}
  .status-icon.green {background:#dcfce7;color:#16a34a;}
  .status-icon.blue  {background:#dbeafe;color:#1d4ed8;}
  .status-icon.teal  {background:#ccfbf1;color:#0d9488;}
  .status-icon.red   {background:#fee2e2;color:#dc2626;}
  .status-label{font-size:1rem;font-weight:700;color:#111827;}
  .status-sub{font-size:.78rem;color:#6b7280;margin-top:2px;}

  /* ── Body ── */
  .email-body{padding:32px 40px;}
  .greeting{font-size:1rem;font-weight:600;color:#111827;margin-bottom:12px;}
  .text{font-size:.88rem;line-height:1.7;color:#4b5563;margin-bottom:14px;}

  /* ── Info box ── */
  .info-box{background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden;margin:20px 0;}
  .info-box-header{background:#f1f5f9;padding:10px 18px;font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;}
  .info-row{display:flex;padding:11px 18px;border-bottom:1px solid #f1f5f9;}
  .info-row:last-child{border-bottom:none;}
  .info-label{font-size:.8rem;font-weight:600;color:#64748b;min-width:160px;flex-shrink:0;}
  .info-value{font-size:.83rem;color:#1e293b;font-weight:500;word-break:break-all;}

  /* ── Mot de passe ── */
  .password-box{background:#fefce8;border:1.5px solid #fde68a;border-radius:8px;padding:14px 18px;margin:16px 0;display:flex;align-items:center;gap:12px;}
  .password-icon{font-size:1.1rem;}
  .password-label{font-size:.75rem;color:#92400e;font-weight:600;margin-bottom:3px;}
  .password-value{font-size:1.05rem;font-weight:800;color:#1e293b;letter-spacing:.08em;font-family:monospace;}

  /* ── Badge ── */
  .badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:700;}
  .badge-green {background:#dcfce7;color:#16a34a;}
  .badge-blue  {background:#dbeafe;color:#1d4ed8;}
  .badge-teal  {background:#ccfbf1;color:#0d9488;}
  .badge-red   {background:#fee2e2;color:#dc2626;}
  .badge-gray  {background:#f3f4f6;color:#6b7280;}

  /* ── Bouton ── */
  .btn-wrap{text-align:center;margin:24px 0 8px;}
  .btn{display:inline-block;background:linear-gradient(135deg,#1d4ed8,#3b82f6);color:#fff;padding:13px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:.9rem;letter-spacing:.01em;box-shadow:0 4px 12px rgba(29,78,216,.3);}

  /* ── Alerte sécurité ── */
  .security-note{background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;display:flex;gap:10px;align-items:flex-start;margin-top:16px;}
  .security-note-icon{font-size:.95rem;margin-top:1px;flex-shrink:0;}
  .security-note-text{font-size:.8rem;color:#92400e;line-height:1.5;}

  /* ── Divider ── */
  .divider{height:1px;background:#f1f5f9;margin:20px 0;}

  /* ── Footer ── */
  .email-footer{background:#f8fafc;padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center;}
  .footer-text{font-size:.74rem;color:#94a3b8;line-height:1.7;}
  .footer-brand{font-weight:700;color:#64748b;}
</style>
</head>
<body>
<div class="outer">
<div class="wrapper">

  {{-- Header --}}
  <div class="email-header">
    <div class="email-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
      </div>
      <div class="logo-text">Ges<span>Projet</span></div>
    </div>
    <div class="header-tagline">Plateforme de gestion de projets</div>
  </div>

  {{-- Bandeau statut --}}
  @yield('status_band')

  {{-- Corps --}}
  <div class="email-body">
    @yield('body')
  </div>

    {{-- Footer --}}
    <div class="email-footer">
    <p class="footer-text">
        Cet email a été envoyé automatiquement par <span class="footer-brand">GesProjet</span>.<br>
        Merci de ne pas répondre directement à ce message.<br>
        © {{ date('Y') }} GesProjet — Tous droits réservés.
    </p>
    </div>

</div>
</div>
</body>
</html>
