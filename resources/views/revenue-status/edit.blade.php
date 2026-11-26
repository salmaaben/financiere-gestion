@extends('adminlte::page')

@section('title', 'Modifier un statut')

@section('content_header')
    <h1>
        <i class="fas fa-edit"></i>
        Modifier un statut de revenu
    </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('revenue-status.update', $revenueStatus->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nom du statut</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $revenueStatus->name) }}"
                    >
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description', $revenueStatus->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Mettre à jour
                </button>

                <a href="{{ route('revenue-status.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </form>
        </div>
    </div>
@stop