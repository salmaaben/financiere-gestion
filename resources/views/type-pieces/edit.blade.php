@extends('adminlte::page')

@section('title','Modifier un type de pièce comptable')

@section('content_header')

<h1>

    <i class="fas fa-edit"></i>

    Modifier un type de pièce comptable

</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('type-pieces.update',$typePiece->id) }}">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Nom</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name',$typePiece->name) }}">

                @error('name')

                    <div class="text-danger">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <button class="btn btn-success">

                <i class="fas fa-save"></i>

                Mettre à jour

            </button>

            <a href="{{ route('type-pieces.index') }}"
               class="btn btn-secondary">

                Annuler

            </a>

        </form>

    </div>

</div>

@stop