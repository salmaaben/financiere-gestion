@extends('adminlte::page')

@section('title','Gestion des types de pièces comptables')

@section('content_header')

<h1>
    <i class="fas fa-file-invoice"></i>
    Gestion des types de pièces comptables
</h1>

@stop

@section('content')

@if(session('success'))

<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>

@endif

<div class="card">

    <div class="card-header">

        <a href="{{ route('type-pieces.create') }}"
           class="btn btn-success">

            <i class="fas fa-plus"></i>

            Nouveau type

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="80">ID</th>
                    <th>Nom</th>
                    <th width="180">Actions</th>

                </tr>

            </thead>

            <tbody>

            @forelse($typePieces as $typePiece)

                <tr>

                    <td>{{ $typePiece->id }}</td>

                    <td>{{ $typePiece->name }}</td>

                    <td>

                        <a href="{{ route('type-pieces.edit',$typePiece->id) }}"
                           class="btn btn-primary btn-sm">

                            <i class="fas fa-edit"></i>

                            Modifier

                        </a>

                        <form action="{{ route('type-pieces.destroy',$typePiece->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Supprimer ce type de pièce ?')">

                                <i class="fas fa-trash"></i>

                                Supprimer

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3" class="text-center">

                        Aucun type de pièce comptable trouvé.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
<a href="{{ route('parametres.index') }}"
   class="btn btn-secondary">

    <i class="fas fa-arrow-left"></i>
    Retour

</a>
@stop