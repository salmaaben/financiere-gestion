@extends('adminlte::page')

@section('title','Gestion des fournisseurs')

@section('content_header')

<h1>
    <i class="fas fa-truck"></i>
    Gestion des fournisseurs
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

        <a href="{{ route('fournisseurs.create') }}"
           class="btn btn-success">

            <i class="fas fa-plus"></i>

            Ajouter un fournisseur

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th width="180">Actions</th>

                </tr>

            </thead>

            <tbody>

            @forelse($fournisseurs as $fournisseur)

                <tr>

                    <td>{{ $fournisseur->id }}</td>
                    <td>{{ $fournisseur->name }}</td>
                    <td>{{ $fournisseur->description }}</td>

                    <td>

                        <a href="{{ route('fournisseurs.edit',$fournisseur->id) }}"
                           class="btn btn-primary btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('fournisseurs.destroy',$fournisseur->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Supprimer ce fournisseur ?')">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        Aucun fournisseur trouvé.

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