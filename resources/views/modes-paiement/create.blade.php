
@extends('adminlte::page')

@section('title', 'Ajouter un mode de paiement')

@section('content_header')
    <h1>Ajouter un mode de paiement</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('modes-paiement.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Libellé du mode de paiement</label>
                <input type="text"
                       name="libelle"
                       class="form-control"
                       value="{{ old('libelle') }}"
                       placeholder="Ex : Espèces, Virement bancaire..."
                       required>
                @error('libelle')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>

            <a href="{{ route('modes-paiement.index') }}"
               class="btn btn-secondary">
                Annuler
            </a>
        </form>

    </div>
</div>

@stop
