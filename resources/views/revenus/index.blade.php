@extends('adminlte::page')

@section('title', 'Revenus')

@section('content_header')
    <h1>Gestion des revenus</h1>
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

    {{-- En-tête --}}
    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title">
            Liste des revenus
        </h3>

        <div>
            <a href="{{ route('revenus.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
                Ajouter un revenu
            </a>
        </div>

    </div>

    {{-- Contenu --}}
    <div class="card-body">

        {{-- Zone de recherche --}}
        <div class="row mb-3">

            <div class="col-md-4">

                <select id="colonneRecherche" class="form-control">

                    <option value="0">Numéro pièce comptable</option>
                    <option value="1">Type de pièce</option>
                    <option value="2">Montant TTC</option>
                    <option value="3">Statut</option>
                    <option value="4">Client</option>
                    <option value="5">Catégorie</option>
                    <option value="6">Libellé</option>
                    <option value="7">Date</option>
                    <option value="8">TVA</option>
                    <option value="9">Montant TVA</option>
                    <option value="10">Devise</option>
                    <option value="11">Mode de paiement</option>
                    <option value="14">Date d'échéance</option>
                    <option value="15">Date de valeur</option>

                </select>

            </div>

            <div class="col-md-5">

                <input
                    type="text"
                    id="valeurRecherche"
                    class="form-control"
                    placeholder="Veuillez rechercher..."
                >

            </div>

            <div class="col-md-3">

                <button
                    type="button"
                    id="btnRecherche"
                    class="btn btn-primary"
                >
                    <i class="fas fa-search"></i>
                    Rechercher
                </button>

                <button
                    type="button"
                    id="btnReset"
                    class="btn btn-secondary"
                >
                    Réinitialiser
                </button>

            </div>

        </div>

        {{-- Tableau --}}
        <div class="table-responsive">

            <table
                id="revenusTable"
                class="table table-bordered table-striped w-100"
            >

                <thead>
                    <tr>
                        <th>Numéro pièce comptable</th>
                        <th>Type de pièce</th>
                        <th>Montant TTC</th>
                        <th>Statut</th>
                        <th>Client</th>
                        <th>Catégorie</th>
                        <th>Libellé</th>
                        <th>Date</th>
                        <th>TVA</th>
                        <th>Montant TVA</th>
                        <th>Devise</th>
                        <th>Mode de paiement</th>
                        <th>Commentaire</th>
                        <th>Justificatif</th>
                        <th>Date d'échéance</th>
                        <th>Date de valeur</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($revenus as $revenu)

            @php
    $statut = trim(mb_strtolower($revenu->statut ?? '', 'UTF-8'));

    if (in_array($statut, ['encaissé', 'encaisse', 'justifié', 'justifie'])) {
        $classeLigne = 'ligne-verte';
    } elseif (in_array($statut, ['non justifié', 'non justifie'])) {
        $classeLigne = 'ligne-rouge';
    } elseif (in_array($statut, ['en retard', 'A encaissé'])) {
        $classeLigne = 'ligne-orange';
    } else {
        $classeLigne = '';
    }
@endphp

                        <tr class="{{ $classeLigne }}">

                            <td>{{ $revenu->numero_piece }}</td>

                            <td>{{ $revenu->type_piece }}</td>

                            <td>{{ number_format($revenu->montant_ttc, 2, ',', ' ') }}</td>

                            <td>{{ $revenu->statut }}</td>

                            <td>{{ $revenu->client }}</td>

                            <td>{{ $revenu->categorie }}</td>

                            <td>{{ $revenu->libelle }}</td>

                            <td>{{ $revenu->date }}</td>

                            <td>
                                @if($revenu->tva)
                                    {{ number_format($revenu->tva->taux, 2) }} %
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ number_format($revenu->montant_tva ?? 0, 2, ',', ' ') }}</td>

                            <td>{{ $revenu->devise }}</td>

                            <td>{{ $revenu->mode_paiement ?: '-' }}</td>

                            <td>{{ $revenu->commentaire ?: '-' }}</td>

                            <td>
                                @if($revenu->lien_justificatif)
                                    <a href="{{ $revenu->lien_justificatif }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-link"></i> Ouvrir
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $revenu->date_echeance ?: '-' }}</td>

                            <td>{{ $revenu->date_valeur ?: '-' }}</td>

                            <td>
    <a href="{{ route('revenus.show', $revenu->id) }}" class="btn btn-info btn-sm mb-1">
        <i class="fas fa-eye"></i> Voir
    </a>

    <a href="{{ route('revenus.edit', $revenu->id) }}" class="btn btn-warning btn-sm mb-1">
        <i class="fas fa-edit"></i> Modifier
    </a>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <form action="{{ route('revenus.destroy', $revenu->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce revenu ?')">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        </form>
    @endif
</td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="17" class="text-center">
                                Aucun revenu enregistré.
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

// Fonction utilitaire pour parser les formats de date (gère à la fois aaaa-mm-jj et aa-mm-jj)
function parseDate(input) {
    if (!input) return null;
    input = input.trim();

    // Format AAAA-MM-DD ou AA-MM-JJ (ex: 2026-05-12 ou 26-05-12)
    let match = input.match(/^(\d{2,4})-(\d{1,2})-(\d{1,2})$/);
    if (match) {
        let year = parseInt(match[1], 10);
        let month = parseInt(match[2], 10) - 1;
        let day = parseInt(match[3], 10);

        // Si l'année est sur 2 chiffres (ex: 26), on la convertit en 2026
        if (year < 100) {
            year += 2000;
        }

        return new Date(year, month, day);
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

        return new Date(year, month, day);
    }

    return null;
}

// Filtre personnalisé pour les dates et plages de dates
$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {

        if (settings.nTable.id !== 'revenusTable') {
            return true;
        }

        let colonne = $('#colonneRecherche').val();
        let valeurRecherche = $('#valeurRecherche').val().trim();

        // Si aucun filtre saisi ou ce n'est pas une colonne de date
        if (
            !valeurRecherche ||
            (colonne !== "7" && colonne !== "14" && colonne !== "15")
        ) {
            return true;
        }

        let dateCelluleStr = data[colonne];
        let dateCellule = parseDate(dateCelluleStr);

        if (!dateCellule) {
            // Si la date du tableau est introuvable ou vide, on fait une recherche textuelle simple
            return dateCelluleStr.toLowerCase().includes(valeurRecherche.toLowerCase());
        }

        // Recherche par plage de dates (avec "à")
        if (valeurRecherche.includes(' à ')) {
            let parties = valeurRecherche.split(' à ');
            let dateDebut = parseDate(parties[0]);
            let dateFin = parseDate(parties[1]);

            if (dateDebut && dateFin) {
                // On remet les heures à zéro pour comparer proprement les jours
                dateCellule.setHours(0, 0, 0, 0);
                dateDebut.setHours(0, 0, 0, 0);
                dateFin.setHours(0, 0, 0, 0);

                return dateCellule >= dateDebut && dateCellule <= dateFin;
            }
        }

        // Recherche d'une date simple (ex: 26-05-12 ou 2026-05-12)
        let dateRecherche = parseDate(valeurRecherche);

        if (dateRecherche) {
            dateCellule.setHours(0, 0, 0, 0);
            dateRecherche.setHours(0, 0, 0, 0);
            return dateCellule.getTime() === dateRecherche.getTime();
        }

        // Solution de repli : recherche partielle de texte
        return dateCelluleStr.toLowerCase().includes(valeurRecherche.toLowerCase());
    }
);

$(document).ready(function () {

    var table = $('#revenusTable').DataTable({

        responsive: true,
        autoWidth: false,
        scrollX: true,

        language: {
            search: "",
            lengthMenu: "Afficher _MENU_ lignes",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ revenus",
            infoEmpty: "Aucun revenu à afficher",
            zeroRecords: "Aucun revenu correspondant trouvé",
            emptyTable: "Aucun revenu enregistré",
            paginate: {
                next: "Suivant",
                previous: "Précédent"
            }
        },

        dom: 'lrtip'

    });

    table.columns.adjust().draw();

    // Adapter le placeholder selon le champ choisi
    function mettreAJourPlaceholder() {
        let colonne = $('#colonneRecherche').val();

        if (colonne === "7" || colonne === "14" || colonne === "15") {
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

    // Initialisation
    mettreAJourPlaceholder();

    // Changement du critère de recherche
    $('#colonneRecherche').change(function() {
        mettreAJourPlaceholder();
        $('#valeurRecherche').val('');
        table.columns().search('');
        table.draw(); // Actualise le tableau avec le filtre personnalisé
    });

    // Recherche au clic sur le bouton
    $('#btnRecherche').click(function () {
        let colonne = $('#colonneRecherche').val();
        let valeur = $('#valeurRecherche').val().trim();

        if (colonne === "7" || colonne === "14" || colonne === "15") {
            // Déclenche le redessinage du tableau qui va exécuter $.fn.dataTable.ext.search
            table.draw();
        } else {
            // Recherche standard DataTables pour les autres colonnes textuelles
            table.columns().search('');
            table.column(parseInt(colonne)).search(valeur).draw();
        }
    });

    // Recherche avec la touche Entrée
    $('#valeurRecherche').keyup(function (e) {
        if (e.key === "Enter") {
            $('#btnRecherche').click();
        }
    });

    // Réinitialiser les filtres
    $('#btnReset').click(function () {
        $('#valeurRecherche').val('');
        $('#colonneRecherche').val('0');
        mettreAJourPlaceholder();

        table.search('')
             .columns()
             .search('')
             .draw();
    });

});
</script>

@stop