@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Récupération du mot de passe')

@section('auth_body')

{{-- Confirmation d'envoi du lien --}}
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Alerte si l'e-mail n'existe pas ou est invalide --}}
@error('email')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <strong>Erreur :</strong> {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@enderror

<p class="login-box-msg">
    Saisissez votre adresse e-mail pour recevoir un lien de réinitialisation.
</p>

<form action="{{ route('password.email') }}" method="POST">
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

    <button type="submit" class="btn btn-primary btn-block">
        Envoyer le lien de réinitialisation
    </button>
</form>

<p class="mt-3 mb-0 text-center">
    <a href="{{ route('login') }}">Retour à la connexion</a>
</p>

@stop
