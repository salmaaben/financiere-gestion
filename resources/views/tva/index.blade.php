@extends('adminlte::page')

@section('title', 'Gestion des TVA')

@section('content_header')

<h1>
    <i class="fas fa-percent"></i>
    Gestion des TVA
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Liste des taux de TVA</h3>

        <div class="card-tools">
            <a href="{{ route('tva.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Ajouter une TVA
            </a>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Libellé</th>
                    <th>Taux (%)</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($tvas as $tva)

                <tr>

                    <td>{{ $tva->id }}</td>

                    <td>{{ $tva->libelle }}</td>

                    <td>{{ $tva->taux }} %</td>

                    <td>

                        <a href="{{ route('tva.edit', $tva->id) }}"
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>

                        <form action="{{ route('tva.destroy', $tva->id) }}"
                              method="POST"
                              style="display:inline-block;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette TVA ?')">

                                <i class="fas fa-trash"></i>
                                Supprimer

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        Aucun taux de TVA enregistré.
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