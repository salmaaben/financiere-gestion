
@extends('adminlte::page')

@section('title', 'Modifier un mode de paiement')

@section('content_header')
    <h1>Modifier un mode de paiement</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('modes-paiement.update', $mode->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Libellé du mode de paiement</label>

                <input type="text"
                       name="libelle"
                       class="form-control"
                       value="{{ old('libelle', $mode->libelle) }}"
                       required>

                @error('libelle')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Enregistrer les modifications
            </button>

            <a href="{{ route('modes-paiement.index') }}"
               class="btn btn-secondary">
                Annuler
            </a>

        </form>

    </div>
</div>

@stop
