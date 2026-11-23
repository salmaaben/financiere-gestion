@extends('adminlte::page')

@section('title', 'Modifier le rapport')

@section('content_header')

<h1>Modifier le rapport financier</h1>

@stop


@section('content')

<form
    action="{{ route('rapports.pdf') }}"
    method="POST"
    target="_blank"
    id="rapportForm"
>

    @csrf


    {{-- ========================================================= --}}
    {{-- DONNÉES TECHNIQUES --}}
    {{-- ========================================================= --}}

    <input
        type="hidden"
        name="date_debut"
        value="{{ $dateDebut }}"
    >

    <input
        type="hidden"
        name="date_fin"
        value="{{ $dateFin }}"
    >

    <input
        type="hidden"
        name="libelle"
        value="{{ $libelle }}"
    >


    {{-- ========================================================= --}}
    {{-- INFORMATIONS GÉNÉRALES --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                Informations générales
            </h3>
        </div>

        <div class="card-body">

            <div class="form-group">

                <label>Titre du rapport</label>

                <input
                    type="text"
                    name="titre"
                    class="form-control"
                    value="Compte rendu financier"
                >

            </div>


            <div class="form-group">

                <label>Nom de l'établissement</label>

                <input
                    type="text"
                    name="nom_etablissement"
                    class="form-control"
                    value="MyStay"
                >

            </div>


            <div class="form-group">

                <label>Période</label>

                <input
                    type="text"
                    name="periode"
                    class="form-control"
                    value="{{ $dateDebut }} au {{ $dateFin }}"
                >

            </div>


            <div class="form-group">

                <label>Commentaire général</label>

                <textarea
                    name="commentaire_general"
                    class="form-control"
                    rows="4"
                ></textarea>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- RÉSUMÉ FINANCIER --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Résumé financier
            </h3>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Libellé</th>

                            <th>Montant</th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="resume_labels[revenus]"
                                    class="form-control"
                                    value="Revenu Client"
                                >

                            </td>

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="resume[revenus]"
                                    class="form-control"
                                    value="{{ $revenuTotal }}"
                                >

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="resume_labels[depenses]"
                                    class="form-control"
                                    value="Charges"
                                >

                            </td>

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="resume[depenses]"
                                    class="form-control"
                                    value="{{ $depenseTotale }}"
                                >

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="resume_labels[tva]"
                                    class="form-control"
                                    value="Taxe d'occupation"
                                >

                            </td>

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="resume[tva]"
                                    class="form-control"
                                    value="{{ $tva }}"
                                >

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="resume_labels[solde]"
                                    class="form-control"
                                    value="Résultat financier"
                                >

                            </td>

                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="resume[solde]"
                                    class="form-control"
                                    value="{{ $solde }}"
                                >

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- CHARGES --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <h3 class="card-title mb-0">
                    Charges
                </h3>

            </div>

            <button
                type="button"
                class="btn btn-primary btn-sm"
                id="addCharge"
            >
                Ajouter une ligne
            </button>

        </div>


        <div class="card-body">

            <div class="form-group">

                <label>Titre de la section</label>

                <input
                    type="text"
                    name="titre_charges"
                    class="form-control"
                    value="Charges"
                >

            </div>


            <div class="table-responsive">

                <table
                    class="table table-bordered"
                    id="chargesTable"
                >

                    <thead>

                        <tr>

                            <th>Catégorie</th>

                            <th>Montant TTC</th>

                            <th>Commentaire</th>

                            <th width="80">Action</th>

                        </tr>

                    </thead>


                    <tbody id="chargesBody">

                        @forelse($depenses as $index => $depense)

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="charges[{{ $index }}][categorie]"
                                        class="form-control"
                                        value="{{ $depense->categorie ?? $depense->libelle ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="charges[{{ $index }}][montant]"
                                        class="form-control"
                                        value="{{ $depense->montant_ttc ?? 0 }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="charges[{{ $index }}][commentaire]"
                                        class="form-control"
                                        value="{{ $depense->commentaire ?? '' }}"
                                    >

                                </td>


                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="charges[0][categorie]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="charges[0][montant]"
                                        class="form-control"
                                        value="0"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="charges[0][commentaire]"
                                        class="form-control"
                                    >

                                </td>

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- RÉSERVATIONS --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">
                Recettes / Réservations
            </h3>

            <button
                type="button"
                class="btn btn-primary btn-sm"
                id="addReservation"
            >
                Ajouter une ligne
            </button>

        </div>


        <div class="card-body">

            <div class="form-group">

                <label>Titre de la section</label>

                <input
                    type="text"
                    name="titre_recettes"
                    class="form-control"
                    value="Recettes / Réservations"
                >

            </div>


            <div class="table-responsive">

                <table
                    class="table table-bordered"
                    id="reservationsTable"
                >

                    <thead>

                        <tr>

                            <th>Client</th>

                            <th>Check-in</th>

                            <th>Check-out</th>

                            <th>Nuitées</th>

                            <th>Montant TTC</th>

                            <th>Commentaire</th>

                            <th width="80">Action</th>

                        </tr>

                    </thead>


                    <tbody id="reservationsBody">

                        @forelse($reservations as $index => $reservation)

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="reservations[{{ $index }}][client]"
                                        class="form-control"
                                        value="{{ $reservation->client ?? $reservation->libelle ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="date"
                                        name="reservations[{{ $index }}][check_in]"
                                        class="form-control"
                                        value="{{ $reservation->check_in ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="date"
                                        name="reservations[{{ $index }}][check_out]"
                                        class="form-control"
                                        value="{{ $reservation->check_out ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        name="reservations[{{ $index }}][nuitees]"
                                        class="form-control"
                                        value="{{ $reservation->nombre_nuitees ?? 0 }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="reservations[{{ $index }}][montant]"
                                        class="form-control"
                                        value="{{ $reservation->montant_ttc ?? 0 }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="reservations[{{ $index }}][commentaire]"
                                        class="form-control"
                                        value="{{ $reservation->commentaire ?? '' }}"
                                    >

                                </td>


                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="reservations[0][client]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="date"
                                        name="reservations[0][check_in]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="date"
                                        name="reservations[0][check_out]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        name="reservations[0][nuitees]"
                                        class="form-control"
                                        value="0"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="reservations[0][montant]"
                                        class="form-control"
                                        value="0"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="reservations[0][commentaire]"
                                        class="form-control"
                                    >

                                </td>

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- OCCUPATION --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Occupation
            </h3>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Indicateur</th>

                            <th>Valeur</th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="occupation_labels[nuitees]"
                                    class="form-control"
                                    value="Total nuitées"
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="occupation[nuitees]"
                                    class="form-control"
                                    value="{{ $totalNuitees }}"
                                >

                            </td>

                        </tr>


                        <tr>

                            <td>

                                <input
                                    type="text"
                                    name="occupation_labels[taux]"
                                    class="form-control"
                                    value="Taux d'occupation (%)"
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="occupation[taux]"
                                    class="form-control"
                                    value="{{ $tauxOccupation }}"
                                >

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- INTERVENTIONS --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">
                Journal des interventions
            </h3>

            <button
                type="button"
                class="btn btn-primary btn-sm"
                id="addIntervention"
            >
                Ajouter une ligne
            </button>

        </div>


        <div class="card-body">

            <div class="form-group">

                <label>Titre de la section</label>

                <input
                    type="text"
                    name="titre_interventions"
                    class="form-control"
                    value="Journal des interventions"
                >

            </div>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Action</th>

                            <th>Date</th>

                            <th>Responsable</th>

                            <th>Commentaire</th>

                            <th width="80">Action</th>

                        </tr>

                    </thead>


                    <tbody id="interventionsBody">

                        @forelse($interventions as $index => $intervention)

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="interventions[{{ $index }}][action]"
                                        class="form-control"
                                        value="{{ $intervention->action ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="date"
                                        name="interventions[{{ $index }}][date]"
                                        class="form-control"
                                        value="{{ $intervention->date ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="interventions[{{ $index }}][responsable]"
                                        class="form-control"
                                        value="{{ $intervention->responsable ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="interventions[{{ $index }}][commentaire]"
                                        class="form-control"
                                        value="{{ $intervention->commentaire ?? '' }}"
                                    >

                                </td>


                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="interventions[0][action]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="date"
                                        name="interventions[0][date]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="interventions[0][responsable]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="interventions[0][commentaire]"
                                        class="form-control"
                                    >

                                </td>

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- ACTIONS D'AMÉLIORATION --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">
                Actions d'amélioration
            </h3>

            <button
                type="button"
                class="btn btn-primary btn-sm"
                id="addAction"
            >
                Ajouter une ligne
            </button>

        </div>


        <div class="card-body">

            <div class="form-group">

                <label>Titre de la section</label>

                <input
                    type="text"
                    name="titre_actions"
                    class="form-control"
                    value="Actions d'amélioration"
                >

            </div>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Action</th>

                            <th>Priorité</th>

                            <th>Commentaires</th>

                            <th width="80">Action</th>

                        </tr>

                    </thead>


                    <tbody id="actionsBody">

                        @forelse($actions as $index => $action)

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="actions[{{ $index }}][action]"
                                        class="form-control"
                                        value="{{ $action->action ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="actions[{{ $index }}][priorite]"
                                        class="form-control"
                                        value="{{ $action->priorite ?? '' }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        name="actions[{{ $index }}][consequence]"
                                        class="form-control"
                                        value="{{ $action->consequence ?? '' }}"
                                    >

                                </td>


                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td>

                                    <input
                                        type="text"
                                        name="actions[0][action]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="actions[0][priorite]"
                                        class="form-control"
                                    >

                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="actions[0][consequence]"
                                        class="form-control"
                                    >

                                </td>

                                <td class="text-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-row"
                                    >
                                        Supprimer
                                    </button>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- PIED DE PAGE --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Pied de page
            </h3>

        </div>


        <div class="card-body">

            <div class="form-group">

                <label>Texte du pied de page</label>

                <input
                    type="text"
                    name="footer"
                    class="form-control"
                    value="MyStay"
                >

            </div>


            <div class="form-group">

                <label>Note finale</label>

                <textarea
                    name="note_finale"
                    class="form-control"
                    rows="4"
                ></textarea>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- BOUTON EXPORT --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-body text-right">

            <button
                type="submit"
                class="btn btn-success"
            >
                Exporter en PDF
            </button>

        </div>

    </div>


</form>

@stop



@section('js')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | Fonction pour supprimer une ligne
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (
            event.target.classList.contains(
                'remove-row'
            )
        ) {

            const row =
                event.target.closest('tr');

            if (row) {
                row.remove();
            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Compteurs
    |--------------------------------------------------------------------------
    */

    let chargeIndex =
        document.querySelectorAll(
            '#chargesBody tr'
        ).length;

    let reservationIndex =
        document.querySelectorAll(
            '#reservationsBody tr'
        ).length;

    let interventionIndex =
        document.querySelectorAll(
            '#interventionsBody tr'
        ).length;

    let actionIndex =
        document.querySelectorAll(
            '#actionsBody tr'
        ).length;


    /*
    |--------------------------------------------------------------------------
    | Ajouter une charge
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('addCharge')
        .addEventListener('click', function () {

            const tbody =
                document.getElementById(
                    'chargesBody'
                );

            const row =
                document.createElement('tr');

            row.innerHTML = `

                <td>

                    <input
                        type="text"
                        name="charges[${chargeIndex}][categorie]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="number"
                        step="0.01"
                        name="charges[${chargeIndex}][montant]"
                        class="form-control"
                        value="0"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="charges[${chargeIndex}][commentaire]"
                        class="form-control"
                    >

                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-row"
                    >
                        Supprimer
                    </button>

                </td>
            `;

            tbody.appendChild(row);

            chargeIndex++;

        });


    /*
    |--------------------------------------------------------------------------
    | Ajouter une réservation
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('addReservation')
        .addEventListener('click', function () {

            const tbody =
                document.getElementById(
                    'reservationsBody'
                );

            const row =
                document.createElement('tr');

            row.innerHTML = `

                <td>

                    <input
                        type="text"
                        name="reservations[${reservationIndex}][client]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="date"
                        name="reservations[${reservationIndex}][check_in]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="date"
                        name="reservations[${reservationIndex}][check_out]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="number"
                        name="reservations[${reservationIndex}][nuitees]"
                        class="form-control"
                        value="0"
                    >

                </td>

                <td>

                    <input
                        type="number"
                        step="0.01"
                        name="reservations[${reservationIndex}][montant]"
                        class="form-control"
                        value="0"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="reservations[${reservationIndex}][commentaire]"
                        class="form-control"
                    >

                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-row"
                    >
                        Supprimer
                    </button>

                </td>
            `;

            tbody.appendChild(row);

            reservationIndex++;

        });


    /*
    |--------------------------------------------------------------------------
    | Ajouter une intervention
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('addIntervention')
        .addEventListener('click', function () {

            const tbody =
                document.getElementById(
                    'interventionsBody'
                );

            const row =
                document.createElement('tr');

            row.innerHTML = `

                <td>

                    <input
                        type="text"
                        name="interventions[${interventionIndex}][action]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="date"
                        name="interventions[${interventionIndex}][date]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="interventions[${interventionIndex}][responsable]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="interventions[${interventionIndex}][commentaire]"
                        class="form-control"
                    >

                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-row"
                    >
                        Supprimer
                    </button>

                </td>
            `;

            tbody.appendChild(row);

            interventionIndex++;

        });


    /*
    |--------------------------------------------------------------------------
    | Ajouter une action
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('addAction')
        .addEventListener('click', function () {

            const tbody =
                document.getElementById(
                    'actionsBody'
                );

            const row =
                document.createElement('tr');

            row.innerHTML = `

                <td>

                    <input
                        type="text"
                        name="actions[${actionIndex}][action]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="actions[${actionIndex}][priorite]"
                        class="form-control"
                    >

                </td>

                <td>

                    <input
                        type="text"
                        name="actions[${actionIndex}][consequence]"
                        class="form-control"
                    >

                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-row"
                    >
                        Supprimer
                    </button>

                </td>
            `;

            tbody.appendChild(row);

            actionIndex++;

        });

});

</script>

@stop