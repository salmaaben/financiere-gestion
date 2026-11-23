@extends('adminlte::page')

@section('title', 'Détail du revenu')

@section('content_header')
    <h1>Détail du revenu</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">

            <tbody>

                <tr>
                    <th width="35%">Numéro de pièce comptable</th>
                    <td>{{ $revenue->numero_piece }}</td>
                </tr>

                <tr>
                    <th>Type de pièce</th>
                    <td>{{ $revenue->type_piece }}</td>
                </tr>

                <tr>
                    <th>Montant TTC</th>
                    <td>{{ $revenue->montant_ttc }}</td>
                </tr>

                <tr>
                    <th>Montant TVA</th>
                    <td>{{ $revenue->montant_tva }}</td>
                </tr>

                <tr>
                    <th>Devise</th>
                    <td>{{ $revenue->devise }}</td>
                </tr>

                <tr>
                    <th>Statut</th>
                    <td>{{ $revenue->statut }}</td>
                </tr>

                <tr>
                    <th>Mode de paiement :</th>
                    <td>{{ $revenue->mode_paiement }}</td>
                </tr>
                
                <tr>
                    <th>Client</th>
                    <td>{{ $revenue->client }}</td>
                </tr>

                <tr>
                    <th>Catégorie</th>
                    <td>{{ $revenue->categorie }}</td>
                </tr>

                <tr>
                    <th>Libellé</th>
                    <td>{{ $revenue->libelle }}</td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td>{{ $revenue->date }}</td>
                </tr>

                <tr>
                    <th>Date d'échéance</th>
                    <td>{{ $revenue->date_echeance }}</td>
                </tr>

                <tr>
                    <th>Date de valeur</th>
                    <td>{{ $revenue->date_valeur }}</td>
                </tr>

                <tr>
                    <th>Check-in</th>
                    <td>{{ $revenue->check_in }}</td>
                </tr>

                <tr>
                    <th>Check-out</th>
                    <td>{{ $revenue->check_out }}</td>
                </tr>

                <tr>
                    <th>Nombre de nuitées</th>
                    <td>{{ $revenue->nombre_nuitees }}</td>
                </tr>

                <tr>
                    <th>Commentaire</th>
                    <td>{{ $revenue->commentaire }}</td>
                </tr>

                <tr>
    <th>Justificatif</th>
    <td>
        @if($revenue->lien_justificatif)
            <a href="{{ $revenue->lien_justificatif }}" target="_blank">
                Ouvrir le justificatif
            </a>
        @else
            Aucun
        @endif
    </td>
</tr>

            </tbody>

        </table>

    </div>

    <div class="card-footer">
        <a href="{{ route('revenus.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>
</div>

@stop