<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller {

    public function create(): View {
        return view('auth.login');
    }

    public function store(LoginRequest $request): \Illuminate\Http\RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();
        $role = Auth::user()->role;
        if (in_array($role, ['admin', 'porteur', 'approbateur', 'validateur', 'planificateur'])) {
            return redirect()->route($role . '.dashboard');
        }
        return redirect()->intended('/');
    }

    public function destroy(Request $request): \Illuminate\Http\RedirectResponse {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}