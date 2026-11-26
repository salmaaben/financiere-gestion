@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Plateforme de Gestion Financière')

@section('auth_body')

{{-- Bloc d'alerte en cas d'erreur --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <strong>Erreur de connexion :</strong> E-mail ou mot de passe incorrect.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="input-group mb-3">
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="Adresse e-mail"
               required
               autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>

    <div class="input-group mb-3">
        <input type="password"
               id="password-input"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Mot de passe"
               required>

        <div class="input-group-append">
            <button type="button"
                    class="input-group-text"
                    id="toggle-password"
                    title="Afficher / masquer le mot de passe"
                    style="cursor: pointer;">
                <span class="fas fa-eye" id="toggle-password-icon"></span>
            </button>
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-block">
        Se connecter
    </button>

    <p class="mt-3 mb-0 text-center">
        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
    </p>
</form>

@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        const toggleIcon = document.getElementById('toggle-password-icon');

        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            // Bascule l'icône œil ouvert / œil barré
            toggleIcon.classList.toggle('fa-eye', !isPassword);
            toggleIcon.classList.toggle('fa-eye-slash', isPassword);
        });
    });
</script>
@stop