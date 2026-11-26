@extends('adminlte::page')

@section('title','Gestion des statuts des revenus')

@section('content_header')

<h1>
    <i class="fas fa-money-check-alt"></i>
    Gestion des statuts des revenus
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

        <a href="{{ route('revenue-status.create') }}"
           class="btn btn-success">

            <i class="fas fa-plus"></i>

            Nouveau statut

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

                @forelse($revenueStatuses as $status)

                <tr>

                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                   
                    <td>

                        <a href="{{ route('revenue-status.edit',$status->id) }}"
                           class="btn btn-primary btn-sm">

                            <i class="fas fa-edit"></i>

                            Modifier

                        </a>

                        <form action="{{ route('revenue-status.destroy',$status->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Supprimer ce statut ?')">

                                <i class="fas fa-trash"></i>

                                Supprimer

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        Aucun statut trouvé.

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