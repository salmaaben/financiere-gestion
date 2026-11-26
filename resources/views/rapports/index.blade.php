@extends('adminlte::page')

@section('title', 'Rapports financiers')


@section('content_header')

    <h1>

        <i class="fas fa-file-alt text-primary"></i>

        Rapport financier

    </h1>

@stop


@section('content')


{{-- =========================================================
     FORMULAIRE
========================================================= --}}

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">

            <i class="fas fa-chart-line"></i>

            Génération du rapport financier

        </h4>

    </div>


    <div class="card-body">

        <form
            action="{{ route('rapports.generer') }}"
            method="POST"
        >

            @csrf


            <div class="row">


                {{-- DATE DEBUT --}}

                <div class="col-md-4">

                    <label>
                        Date début
                    </label>

                    <input
                        type="date"
                        name="date_debut"
                        class="form-control"
                        required
                        value="{{ old(
                            'date_debut',
                            request('date_debut')
                        ) }}"
                    >

                </div>


                {{-- DATE FIN --}}

                <div class="col-md-4">

                    <label>
                        Date fin
                    </label>

                    <input
                        type="date"
                        name="date_fin"
                        class="form-control"
                        required
                        value="{{ old(
                            'date_fin',
                            request('date_fin')
                        ) }}"
                    >

                </div>


                {{-- LIBELLE --}}
<div class="col-md-3">
    <label>
        Libellé
    </label>

    <select name="libelle" class="form-control">
        <option value="">-- Sélectionnez un libellé --</option>
        
        @foreach(($libellesExistants ?? []) as $item)
            <option value="{{ $item }}" 
                {{ (old('libelle', request('libelle')) == $item) ? 'selected' : '' }}>
                {{ $item }}
            </option>
        @endforeach
    </select>
</div>

                {{-- BOUTON --}}

                <div class="col-md-1 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-success btn-block"
                        title="Générer"
                    >

                        <i class="fas fa-search"></i>

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>



{{-- =========================================================
     RESULTAT
========================================================= --}}

@if(isset($revenus))


<div class="row mt-4">


    {{-- REVENUS --}}

    <div class="col-md-3">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>

                    {{ number_format(
                        $revenuTotal ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                    <small>MAD</small>

                </h3>

                <p>
                    Revenus
                </p>

            </div>


            <div class="icon">

                <i class="fas fa-coins"></i>

            </div>

        </div>

    </div>



    {{-- DEPENSES --}}

    <div class="col-md-3">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>

                    {{ number_format(
                        $depenseTotale ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                    <small>MAD</small>

                </h3>

                <p>
                    Dépenses
                </p>

            </div>


            <div class="icon">

                <i class="fas fa-dollar-sign"></i>

            </div>

        </div>

    </div>



    {{-- SOLDE --}}

    <div class="col-md-3">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>

                    {{ number_format(
                        $solde ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                    <small>MAD</small>

                </h3>

                <p>
                    Solde
                </p>

            </div>


            <div class="icon">

                <i class="fas fa-wallet"></i>

            </div>

        </div>

    </div>



    {{-- DEPENSES / REVENUS --}}

    <div class="col-md-3">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>

                    {{ $pourcentage ?? 0 }} %

                </h3>

                <p>
                    Revenus dépensés
                </p>

            </div>


            <div class="icon">

                <i class="fas fa-percentage"></i>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     APERCU
========================================================= --}}

<div class="card shadow">

    <div class="card-header bg-secondary text-white">

        <h5 class="mb-0">

            <i class="fas fa-file-alt"></i>

            Aperçu du rapport

        </h5>

    </div>


    <div class="card-body">


        {{-- PERIODE --}}

        <div class="row">

            <div class="col-md-6">

                <strong>
                    Période :
                </strong>

                {{ $dateDebut ?? request('date_debut') }}

                au

                {{ $dateFin ?? request('date_fin') }}

            </div>


            <div class="col-md-6 text-right">

                @if(!empty($libelle))

                    <strong>
                        Libellé :
                    </strong>

                    {{ $libelle }}

                @endif

            </div>

        </div>


        <hr>



        {{-- RESUME --}}

        <table class="table table-bordered">

            <tbody>


                <tr>

                    <th>
                        Revenus
                    </th>

                    <td class="text-right">

                        {{ number_format(
                            $revenuTotal ?? 0,
                            2,
                            ',',
                            ' '
                        ) }}

                        MAD

                    </td>

                </tr>


                <tr>

                    <th>
                        Dépenses
                    </th>

                    <td class="text-right text-danger">

                        {{ number_format(
                            $depenseTotale ?? 0,
                            2,
                            ',',
                            ' '
                        ) }}

                        MAD

                    </td>

                </tr>


                <tr>

                    <th>
                        TVA
                    </th>

                    <td class="text-right">

                        {{ number_format(
                            $tva ?? 0,
                            2,
                            ',',
                            ' '
                        ) }}

                        MAD

                    </td>

                </tr>


                <tr>

                    <th>
                        Solde
                    </th>

                    <td class="text-right">

                        <strong>

                            {{ number_format(
                                $solde ?? 0,
                                2,
                                ',',
                                ' '
                            ) }}

                            MAD

                        </strong>

                    </td>

                </tr>


                <tr>

                    <th>
                        Nombre de nuitées
                    </th>

                    <td class="text-right">

                        {{ $totalNuitees ?? 0 }}

                    </td>

                </tr>


                <tr>

                    <th>
                        Taux d'occupation
                    </th>

                    <td class="text-right">

                        {{ $tauxOccupation ?? 0 }} %

                    </td>

                </tr>


            </tbody>

        </table>



        {{-- =================================================
             APERCU DES RECETTES
        ================================================= --}}

        <h5 class="mt-4">

            <i class="fas fa-bed text-primary"></i>

            Recettes / Réservations

        </h5>


        <div class="table-responsive">

            <table class="table table-bordered table-sm">

                <thead class="thead-light">

                    <tr>

                        <th>
                            Client
                        </th>

                        <th>
                            Check-in
                        </th>

                        <th>
                            Check-out
                        </th>

                        <th>
                            Nuitées
                        </th>

                        <th class="text-right">
                            Montant
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse(($reservations ?? []) as $reservation)

                        <tr>

                            <td>

                                {{ $reservation->client ?? '' }}

                            </td>


                            <td>

                                @if(!empty($reservation->check_in))

                                    {{ \Carbon\Carbon::parse(
                                        $reservation->check_in
                                    )->format('d/m/Y') }}

                                @endif

                            </td>


                            <td>

                                @if(!empty($reservation->check_out))

                                    {{ \Carbon\Carbon::parse(
                                        $reservation->check_out
                                    )->format('d/m/Y') }}

                                @endif

                            </td>


                            <td>

                                {{ $reservation->nombre_nuitees ?? 0 }}

                            </td>


                            <td class="text-right">

                                {{ number_format(
                                    $reservation->montant_ttc ?? 0,
                                    2,
                                    ',',
                                    ' '
                                ) }}

                                MAD

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted"
                            >

                                Aucune réservation enregistrée.

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>



        {{-- =================================================
             PDF
        ================================================= --}}

    <div class="mt-4 d-flex justify-content-between">

    {{-- MODIFIER LE RAPPORT --}}
    <a
        href="{{ route('rapports.modifier', [
            'date_debut' => $dateDebut ?? request('date_debut'),
            'date_fin' => $dateFin ?? request('date_fin'),
            'libelle' => $libelle ?? request('libelle')
        ]) }}"
        class="btn btn-primary btn-lg"
        target="_blank"
    >
        <i class="fas fa-edit"></i>
        Modifier le rapport
    </a>

    {{-- EXPORT EXCEL --}}
    <a
        href="{{ route('rapports.excel', [
            'date_debut' => $dateDebut ?? request('date_debut'),
            'date_fin' => $dateFin ?? request('date_fin'),
            'libelle' => $libelle ?? request('libelle')
        ]) }}"
        class="btn btn-success btn-lg"
    >
        <i class="fas fa-file-excel"></i>
        Exporter Excel
    </a>

</div>
    </div>

</div>


@endif


@stop
