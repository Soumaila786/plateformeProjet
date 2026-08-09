<div style="display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
            background:#f8fafc;
            flex-direction:column;
            gap:16px;
            text-align:center;
            padding:20px;">
    <div style="width:60px;
                height:60px;
                background:#fef2f2;
                border-radius:16px;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:1.8rem;">
        🔧
    </div>
    <h2 style="font-size:1.4rem;font-weight:800;color:#111827;margin:0;">
        {{ $sysConfig->get('nom_app', 'GesProjet') }} est en maintenance
    </h2>
    <p style="font-size:.9rem;color:#6b7280;max-width:400px;margin:0;">
        Nous effectuons des opérations de maintenance. Veuillez réessayer dans quelques instants.
    </p>
    @auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="padding:8px 18px;background:#f3f4f6;border:1px solid #e5e7eb;
                border-radius:8px;font-size:.82rem;cursor:pointer;color:#374151;">
            Se déconnecter
        </button>
    </form>
    @endauth
</div>
