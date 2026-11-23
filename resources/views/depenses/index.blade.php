@extends('adminlte::page')

@section('title', 'Dépenses')

@section('content_header')
    <h1>Gestion des dépenses</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<style>
    .ligne-verte td {
        background-color: #d4edda !important;
    }

    .ligne-rouge td {
        background-color: #f8d7da !important;
    }

    .ligne-orange td {
        background-color: #ffe5b4 !important;
    }
</style>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title">
            Liste des dépenses
        </h3>

        <a href="{{ route('expenses.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i>
            Ajouter une dépense
        </a>

    </div>

    <div class="card-body">

        {{-- Recherche --}}
        <div class="row mb-3">

            <div class="col-md-4">
                <select id="colonneRecherche" class="form-control">

                    <option value="0">Numéro de pièce comptable</option>
                    <option value="1">Type</option>
                    <option value="2">Mode de paiement</option>
                    <option value="3">Montant TTC</option>
                    <option value="4">TVA</option>
                    <option value="5">Montant TVA</option>
                    <option value="6">Statut</option>
                    <option value="7">Fournisseur</option>
                    <option value="8">Catégorie</option>
                    <option value="9">Libellé</option>
                    <option value="10">Date</option>
                    <option value="11">Date d'échéance</option>
                    <option value="12">Date de valeur</option>
                    <option value="13">Devise</option>

                </select>
            </div>

            <div class="col-md-5">

                <input type="text"
                       id="valeurRecherche"
                       class="form-control"
                       placeholder="Veuillez rechercher...">

            </div>

            <div class="col-md-3">

                <button type="button"
                        id="btnRecherche"
                        class="btn btn-primary">

                    <i class="fas fa-search"></i>
                    Rechercher

                </button>

                <button type="button"
                        id="btnReset"
                        class="btn btn-secondary">

                    Réinitialiser

                </button>

            </div>

        </div>

        {{-- Tableau --}}
        <div class="table-responsive">

            <table id="expensesTable"
                   class="table table-bordered table-striped w-100">

                <thead>

                    <tr>
                        <th>Numéro pièce comptable</th>
                        <th>Type</th>
                        <th>Mode paiement</th>
                        <th>Montant TTC</th>
                        <th>TVA</th>
                        <th>Montant TVA</th>
                        <th>Statut</th>
                        <th>Fournisseur</th>
                        <th>Catégorie</th>
                        <th>Libellé</th>
                        <th>Date</th>
                        <th>Date d'échéance</th>
                        <th>Date de valeur</th>
                        <th>Devise</th>
                        <th>Commentaire</th>
                        <th>Justificatif paiement</th>
                        <th>Justificatif comptable</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($expenses as $expense)

                    @php

                        $statut = trim(mb_strtolower($expense->statut ?? '', 'UTF-8'));

                        $classeLigne = match ($statut) {

                            'payé', 'paye', 'justifié', 'justifie'
                                => 'ligne-verte',

                            'en retard', 'non justifié', 'non justifie'
                                => 'ligne-rouge',

                            'à payer', 'a payer'
                                => 'ligne-orange',

                            default => ''

                        };

                    @endphp

                    <tr class="{{ $classeLigne }}">

                        <td>{{ $expense->numero_piece }}</td>

                        <td>{{ $expense->type }}</td>

                        <td>{{ $expense->mode_paiement }}</td>

                        <td>
                            {{ number_format($expense->montant_ttc, 2, '.', ' ') }}
                        </td>

                        <td>
                            @if($expense->tva)
                                {{ number_format($expense->tva->taux, 2) }} %
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            {{ number_format($expense->montant_tva, 2, '.', ' ') }}
                        </td>

                        <td>{{ $expense->statut }}</td>

                        <td>{{ $expense->fournisseur }}</td>

                        <td>{{ $expense->categorie }}</td>

                        <td>{{ $expense->libelle }}</td>

                        <td>{{ $expense->date }}</td>

                        <td>{{ $expense->date_echeance }}</td>

                        <td>{{ $expense->date_valeur }}</td>

                        <td>{{ $expense->devise }}</td>

                        <td>{{ $expense->commentaire }}</td>

                        {{-- Justificatif paiement --}}
                        <td>

                            @if($expense->lien_justificatif)

                                <a href="{{ $expense->lien_justificatif }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm">

                                    <i class="fas fa-link"></i>
                                    Ouvrir

                                </a>

                            @else
                                -
                            @endif

                        </td>

                        {{-- Justificatif comptable --}}
                        <td>

                            @if($expense->lien_justificatif_comptable)

                                <a href="{{ $expense->lien_justificatif_comptable }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm">

                                    <i class="fas fa-link"></i>
                                    Ouvrir

                                </a>

                            @else
                                -
                            @endif

                        </td>

                        {{-- Actions --}}
                        <td>
    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info btn-sm mb-1">
        <i class="fas fa-eye"></i> Voir
    </a>

    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm mb-1">
        <i class="fas fa-edit"></i> Modifier
    </a>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?')">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        </form>
    @endif
</td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="18" class="text-center">
                            Aucune dépense enregistrée.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@stop


@section('js')

<script>

// ==========================================
// Conversion des dates (gère aaaa-mm-jj, aa-mm-jj et jj/mm/aaaa)
// ==========================================

function parseDate(input) {

    if (!input) return null;

    input = input.trim();

    // Format AAAA-MM-DD ou AA-MM-JJ (ex: 2026-05-12 ou 26-05-12)
    let match = input.match(/^(\d{2,4})-(\d{1,2})-(\d{1,2})$/);
    if (match) {
        let year = parseInt(match[1], 10);
        let month = parseInt(match[2], 10) - 1;
        let day = parseInt(match[3], 10);

        if (year < 100) {
            year += 2000;
        }

        let date = new Date(year, month, day);

        if (
            date.getFullYear() !== year ||
            date.getMonth() !== month ||
            date.getDate() !== day
        ) {
            return null;
        }

        return date;
    }

    // Format DD/MM/YYYY ou DD/MM/YY
    let matchSlash = input.match(/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/);
    if (matchSlash) {
        let day = parseInt(matchSlash[1], 10);
        let month = parseInt(matchSlash[2], 10) - 1;
        let year = parseInt(matchSlash[3], 10);

        if (year < 100) {
            year += (year < 50 ? 2000 : 1900);
        }

        let date = new Date(year, month, day);

        if (
            date.getFullYear() !== year ||
            date.getMonth() !== month ||
            date.getDate() !== day
        ) {
            return null;
        }

        return date;
    }

    return null;
}


// ==========================================
// Initialisation DataTables
// ==========================================

$(document).ready(function () {

    var table = $('#expensesTable').DataTable({

        responsive: true,
        autoWidth: false,
        scrollX: true,

        language: {

            search: "",

            lengthMenu: "Afficher _MENU_ lignes",

            info: "Affichage de _START_ à _END_ sur _TOTAL_ dépenses",

            infoEmpty: "Aucune dépense à afficher",

            zeroRecords: "Aucun résultat trouvé.",

            emptyTable: "Aucune dépense enregistrée.",

            paginate: {
                next: "Suivant",
                previous: "Précédent"
            }

        },

        dom: 'lrtip'

    });


    // ==========================================
    // Placeholder dynamique (Colonnes 10, 11, 12 = Dates)
    // ==========================================

    function mettreAJourPlaceholder() {

        let colonne = $('#colonneRecherche').val();

        if (["10", "11", "12"].includes(colonne)) {

            $('#valeurRecherche').attr(
                'placeholder',
                'Saisir date aa-mm-jj ou aa-mm-jj à aa-mm-jj'
            );

        } else {

            $('#valeurRecherche').attr(
                'placeholder',
                'Veuillez rechercher...'
            );

        }

    }


    // ==========================================
    // Recherche
    // ==========================================

    function effectuerRecherche() {

        let colonne = parseInt($('#colonneRecherche').val());

        let valeur = $('#valeurRecherche').val().trim();

        // Supprimer les anciens filtres de date
        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
            function(filter) {
                return !filter._expenseDateFilter;
            }
        );

        table.search('');

        table.columns().search('');


        // Champ vide : afficher toutes les dépenses
        if (valeur === '') {

            table.draw();

            return;
        }


        // Recherche par date (Colonnes 10, 11, 12)
        if ([10, 11, 12].includes(colonne)) {

            let dateDebut;
            let dateFin;

            if (valeur.includes(' à ')) {

                let parties = valeur.split(' à ');

                if (parties.length !== 2) {
                    alert('Veuillez saisir une période valide.');
                    return;
                }

                dateDebut = parseDate(parties[0]);
                dateFin = parseDate(parties[1]);

            } else {

                dateDebut = parseDate(valeur);
                dateFin = dateDebut;

            }

            if (
                !dateDebut ||
                !dateFin ||
                dateDebut > dateFin
            ) {

                alert('Veuillez saisir une date ou une période valide.');

                return;

            }

            // Filtre personnalisé des dates
            let filtreDate = function(settings, data) {

                if (settings.nTable.id !== 'expensesTable') {
                    return true;
                }

                let dateCellule = parseDate(data[colonne]);

                if (!dateCellule) {
                    return false;
                }

                dateCellule.setHours(0, 0, 0, 0);
                dateDebut.setHours(0, 0, 0, 0);
                dateFin.setHours(0, 0, 0, 0);

                return dateCellule >= dateDebut &&
                       dateCellule <= dateFin;

            };

            filtreDate._expenseDateFilter = true;

            $.fn.dataTable.ext.search.push(filtreDate);

            table.draw();

        } else {

            // Recherche textuelle dans la colonne sélectionnée
            table.column(colonne)
                 .search(valeur, false, true)
                 .draw();

        }

    }


    // ==========================================
    // Initialisation
    // ==========================================

    mettreAJourPlaceholder();


    // Changement de colonne
    $('#colonneRecherche').on('change', function() {

        $('#valeurRecherche').val('');

        mettreAJourPlaceholder();

        // Supprimer les filtres précédents
        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
            function(filter) {
                return !filter._expenseDateFilter;
            }
        );

        table.search('').columns().search('').draw();

    });


    // Bouton rechercher
    $('#btnRecherche').on('click', function() {

        effectuerRecherche();

    });


    // Recherche avec Entrée
    $('#valeurRecherche').on('keyup', function(e) {

        if (e.key === 'Enter') {

            effectuerRecherche();

        }

    });


    // ==========================================
    // Réinitialisation
    // ==========================================

    $('#btnReset').on('click', function() {

        $('#valeurRecherche').val('');

        $('#colonneRecherche').val('0');

        mettreAJourPlaceholder();

        // Supprimer les filtres personnalisés
        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(
            function(filter) {
                return !filter._expenseDateFilter;
            }
        );

        table.search('');

        table.columns().search('');

        table.draw();

    });

});

</script>

@stop