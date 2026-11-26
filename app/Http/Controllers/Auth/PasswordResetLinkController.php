<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Veuillez saisir votre adresse e-mail.',
            'email.email'    => 'Veuillez saisir une adresse e-mail valide.',
            'email.exists'   => 'Aucun compte n\'est associé à cette adresse e-mail.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return back()->with('status', __($status));
    }
}
