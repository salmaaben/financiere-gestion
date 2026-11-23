@extends('adminlte::page')

@section('title','Modifier un statut')

@section('content_header')

<h1>

    <i class="fas fa-edit"></i>

    Modifier un statut de dépense

</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('expense-status.update',$expenseStatus->id) }}">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Nom du statut</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name',$expenseStatus->name) }}">

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

            <a href="{{ route('expense-status.index') }}"
               class="btn btn-secondary">

                Annuler

            </a>

        </form>

    </div>

</div>

@stop