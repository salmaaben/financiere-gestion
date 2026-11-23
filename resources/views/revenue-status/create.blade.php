@extends('adminlte::page')

@section('title', 'Ajouter un statut')

@section('content_header')

<h1>
    <i class="fas fa-plus-circle"></i>
    Ajouter un statut de revenu
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('revenue-status.store') }}">

            @csrf

            <div class="form-group">

                <label>Nom du statut</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}">

                @error('name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button type="submit" class="btn btn-success">

                <i class="fas fa-save"></i>

                Enregistrer

            </button>

            <a href="{{ route('revenue-status.index') }}"
               class="btn btn-secondary">

                Annuler

            </a>

        </form>

    </div>

</div>

@stop