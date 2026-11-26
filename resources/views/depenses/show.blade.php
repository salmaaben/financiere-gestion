@extends('adminlte::page')

@section('title', 'Détail de la dépense')

@section('content_header')
    <h1>Détail de la dépense</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <table class="table table-bordered">

            <tbody>

                <tr>
                    <th width="35%">Numéro de pièce comptable</th>
                    <td>{{ $expense->numero_piece }}</td>
                </tr>

                <tr>
                    <th>Type</th>
                    <td>{{ $expense->type }}</td>
                </tr>

                <tr>
                    <th>Mode de paiement</th>
                    <td>{{ $expense->mode_paiement }}</td>
                </tr>

                <tr>
                    <th>Montant TTC</th>
                    <td>{{ $expense->montant_ttc }}</td>
                </tr>

                <tr>
                    <th>Montant TVA</th>
                    <td>{{ $expense->montant_tva }}</td>
                </tr>

                <tr>
                    <th>Devise</th>
                    <td>{{ $expense->devise }}</td>
                </tr>

                <tr>
                    <th>Statut</th>
                    <td>{{ $expense->statut }}</td>
                </tr>

                <tr>
                    <th>Fournisseur</th>
                    <td>{{ $expense->fournisseur }}</td>
                </tr>

                <tr>
                    <th>Catégorie</th>
                    <td>{{ $expense->categorie }}</td>
                </tr>

                <tr>
                    <th>Libellé</th>
                    <td>{{ $expense->libelle }}</td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td>{{ $expense->date }}</td>
                </tr>

                <tr>
                    <th>Commentaire</th>
                    <td>{{ $expense->commentaire }}</td>
                </tr>

                <tr>
                    <th>Justificatif</th>
                    <td>
                        @if($expense->lien_justificatif)
                            <a href="{{ $expense->lien_justificatif }}"
                               target="_blank"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-link"></i>
                                Ouvrir le justificatif
                            </a>
                        @else
                            Aucun justificatif
                        @endif
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Retour
        </a>

        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Modifier
        </a>

    </div>

</div>

@stop