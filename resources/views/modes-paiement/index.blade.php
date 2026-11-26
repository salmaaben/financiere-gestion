
@extends('adminlte::page')

@section('title', 'Modes de paiement')

@section('content_header')
    <h1>
        <i class="fas fa-credit-card"></i>
        Gestion des modes de paiement
    </h1>
@stop

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <a href="{{ route('modes-paiement.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un mode de paiement
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="10%">ID</th>
                    <th>Libellé</th>
                    <th width="25%">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($modes as $mode)
                    <tr>
                        <td>{{ $mode->id }}</td>
                        <td>{{ $mode->libelle }}</td>
                        <td>
                            <a href="{{ route('modes-paiement.edit', $mode->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>

                            <form action="{{ route('modes-paiement.destroy', $mode->id) }}"
                                  method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Voulez-vous supprimer ce mode de paiement ?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            Aucun mode de paiement enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@stop
