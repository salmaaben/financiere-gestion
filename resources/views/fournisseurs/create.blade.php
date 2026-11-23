@extends('adminlte::page')

@section('title','Ajouter un fournisseur')

@section('content_header')

<h1>
    <i class="fas fa-plus"></i>
    Ajouter un fournisseur
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('fournisseurs.store') }}">

            @csrf

            <div class="form-group">

                <label>Nom du fournisseur</label>

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

            <div class="form-group">

                <label>Description</label>

                <textarea name="description"
                          class="form-control"
                          rows="4">{{ old('description') }}</textarea>

            </div>

            <button type="submit" class="btn btn-success">
                Enregistrer
            </button>

            <a href="{{ route('fournisseurs.index') }}"
               class="btn btn-secondary">
                Annuler
            </a>

        </form>

    </div>

</div>

@stop