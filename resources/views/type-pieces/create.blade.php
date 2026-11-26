@extends('adminlte::page')

@section('title','Ajouter un type de pièce comptable')

@section('content_header')

<h1>

    <i class="fas fa-file-invoice"></i>

    Ajouter un type de pièce comptable

</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('type-pieces.store') }}">

            @csrf

            <div class="form-group">

                <label>Nom</label>

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

            <button class="btn btn-success">

                <i class="fas fa-save"></i>

                Enregistrer

            </button>

            <a href="{{ route('type-pieces.index') }}"
               class="btn btn-secondary">

                Annuler

            </a>

        </form>

    </div>

</div>

@stop