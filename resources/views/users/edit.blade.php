@extends('adminlte::page')

@section('title', 'Modifier utilisateur')


@section('content_header')
    <h1>Modifier utilisateur</h1>
@stop


@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('users.update', $user->id) }}">

            @csrf
            @method('PUT')


            <div class="form-group">
                <label>Nom</label>

                <input type="text" 
                       name="name" 
                       class="form-control"
                       value="{{ old('name', $user->name) }}">

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>



            <div class="form-group">
                <label>Email</label>

                <input type="email" 
                       name="email" 
                       class="form-control"
                       value="{{ old('email', $user->email) }}">

                @error('email')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>



            <div class="form-group">
                <label>Nouveau mot de passe</label>

                <input type="password" 
                       name="password" 
                       class="form-control">

                <small class="text-muted">
                    Laisser vide pour conserver l'ancien mot de passe
                </small>

            </div>




            <div class="form-group">

                <label>Rôle</label>

                <select name="role" class="form-control">


                    <option value="admin"
                    {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Responsable financier
                    </option>


                    <option value="user"
                    {{ $user->role == 'user' ? 'selected' : '' }}>
                        Agent back office
                    </option>


                </select>

            </div>




            <button type="submit" class="btn btn-success">
                Enregistrer les modifications
            </button>


            <a href="{{ route('users.index') }}" 
               class="btn btn-secondary">
                Annuler
            </a>


        </form>


    </div>

</div>


@stop