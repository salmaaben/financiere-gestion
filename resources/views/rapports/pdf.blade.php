<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Rapport Stays&Co.</title>

    <style>

        @page {
            size: A4 portrait;
            margin: 18px 25px 25px 25px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 7px;
            color: #555;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            margin-bottom: 8px;
        }

        .header td {
            vertical-align: top;
            border: none;
        }

        .logo {
            width: 85px;
            height: auto;
        }

        .title {
            font-size: 11px;
            font-weight: bold;
            color: #222;
        }

        .small {
            font-size: 7px;
            color: #555;
        }

        /* =====================================================
           RESUME
        ===================================================== */

        .summary {
            width: 100%;
        }

        .summary td {
            border: 1px solid #eee;
            text-align: center;
            padding: 5px;
            height: 35px;
        }

        .label {
            font-size: 6px;
        }

        .value {
            font-size: 8px;
            font-weight: bold;
            color: #222;
            margin-top: 3px;
        }

        .green {
            background: #00ff00;
            color: #000;
        }

        .red {
            color: red;
        }

        /* =====================================================
           SECTIONS
        ===================================================== */

        .section {
            background: #c7dcf5;
            color: #222;
            font-size: 8px;
            font-weight: bold;
            padding: 4px 6px;
            margin-top: 7px;
            margin-bottom: 4px;
        }

        /* =====================================================
           TABLEAUX
        ===================================================== */

        .data {
            width: 100%;
        }

        .data th {
            background: #f4f4f4;
            border-bottom: 1px solid #999;
            padding: 4px;
            font-size: 6px;
            text-align: left;
        }

        .data td {
            border-bottom: 1px solid #eee;
            padding: 4px;
            font-size: 6px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total {
            font-weight: bold;
            border-top: 1px solid #777;
        }

        .red-row td {
            background: red;
            color: white;
            font-weight: bold;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            position: fixed;
            bottom: 5px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 6px;
            color: #999;
        }

    </style>

</head>


<body>


{{-- =========================================================
     HEADER
========================================================= --}}

@php
    /*
     * Numéro du rapport.
     * Aucun stockage en base de données.
     */
    $reportNumber = random_int(10000, 99999);
@endphp


<table class="header"
       width="100%"
       cellpadding="0"
       cellspacing="0"
       border="0"
       style="
            width:100%;
            border-collapse:collapse;
            margin:0 0 8px 0;
            padding:0;
            border-bottom:1px solid #ddd;
       ">

    <tr>

        {{-- =================================================
             GAUCHE : LOGO + DATE + NUMERO
        ================================================== --}}

        <td width="65%"
            valign="top"
            style="
                width:65%;
                vertical-align:top;
                padding:0 0 8px 0;
            ">

          <img
    src="{{ public_path('images/image.png') }}"
    width="85"
    style="
        width:85px;
        height:auto;
        display:block;
    "
>

    @if(!empty($libelle))
        <h4 style="font-size: 10px; margin-bottom: 5px;">
    {{ $libelle }}
</h4>
    @endif
    <div
                class="title"
                style="margin-top:25px;"
            >
                {{ ucfirst(
                    ($dateDebut
                        ? \Carbon\Carbon::parse($dateDebut)
                        : now()
                    )->locale('fr')->translatedFormat('F Y')
                ) }}
            </div>


            <div
                class="small"
                style="margin-top:8px;"
            >
                Earning Report N° {{ $reportNumber }}
            </div>

        </td>


        {{-- =================================================
             DROITE : INFORMATIONS STAYS&CO.
        ================================================== --}}

        <td width="35%"
            valign="top"
            style="
                width:35%;
                vertical-align:top;
                padding:0 0 8px 0;
                font-size:8px;
                line-height:1.4;
            ">

            <strong>Stays&Co.</strong>

            <br>

            24, Avenue de France Bureau 9

            <br>

            10090 Agdal

            <br>

            Rabat - Maroc

        </td>

    </tr>

</table>


{{-- =========================================================
     RESUME
========================================================= --}}

<table class="summary">

    <tr>

        <td>

            <div class="label">
                Revenu Client
            </div>

            <div class="value">

                {{ number_format(
                    $revenuTotal ?? 0,
                    2,
                    ',',
                    ' '
                ) }}

                MAD

            </div>

        </td>


        <td>

            <div class="label">
                Charges
            </div>

            <div class="value red">

                {{ number_format(
                    $depenseTotale ?? 0,
                    2,
                    ',',
                    ' '
                ) }}

                MAD

            </div>

        </td>


        <td>

            <div class="label">
                Aménagements
            </div>

            <div class="value">

                {{ number_format(
                    $amenagementTotal ?? 0,
                    2,
                    ',',
                    ' '
                ) }}

                MAD

            </div>

        </td>


        <td>

            <div class="label">
                Taxe d'occupation
            </div>

            <div class="value">

                {{ number_format(
                    $tva ?? 0,
                    2,
                    ',',
                    ' '
                ) }}

                MAD

            </div>

        </td>


        <td class="green">

            <div class="label">
                Résultat financier
            </div>

            <div class="value">

                {{ number_format(
                    $solde ?? 0,
                    2,
                    ',',
                    ' '
                ) }}

                MAD

            </div>

        </td>

    </tr>

</table>


{{-- =========================================================
     CHARGES
========================================================= --}}

<div class="section">
    Charges
</div>


@php

    $toutesLesDepenses = collect($depenses ?? []);


    /*
     * Charges courantes
     */

    $chargesCourantes = $toutesLesDepenses->filter(
        function ($depense) {

            $categorie = strtolower(
                trim(
                    $depense->categorie ?? ''
                )
            );

            return in_array(
                $categorie,
                [
                    'eau',
                    'eau/électricité',
                    'eau/electricite',
                    'électricité',
                    'electricite',
                    'internet',
                    'ménage',
                    'menage'
                ]
            );

        }
    );


    /*
     * Aménagements et maintenance
     */

    $amenagementsMaintenance = $toutesLesDepenses->filter(
        function ($depense) {

            $categorie = strtolower(
                trim(
                    $depense->categorie ?? ''
                )
            );

            return $categorie === 'syndic';

        }
    );


    /*
     * Total charges courantes
     */

    $totalChargesCourantes =
        $chargesCourantes->sum(
            function ($depense) {

                return (float) (
                    $depense->montant_ttc ?? 0
                );

            }
        );

@endphp


{{-- =========================================================
     CHARGES COURANTES
========================================================= --}}

<table class="data">

    <thead>

        <tr>

            <th style="width:55%;">
                Charges courantes
            </th>

            <th style="width:15%;">
                Montant
            </th>

            <th style="width:30%;">
                Commentaires
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($chargesCourantes as $depense)

            <tr>

                <td>
                    {{ $depense->categorie ?? '' }}
                </td>

                <td class="right">

                    {{ number_format(
                        $depense->montant_ttc ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                </td>

                <td>

                    {{ $depense->commentaire
                        ?? $depense->description
                        ?? '' }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="3"
                    class="center"
                >
                    Aucune charge courante enregistrée.
                </td>

            </tr>

        @endforelse


        @if($chargesCourantes->count() > 0)

            <tr class="total">

                <td>
                    Total
                </td>

                <td class="right">

                    {{ number_format(
                        $totalChargesCourantes,
                        2,
                        ',',
                        ' '
                    ) }}

                </td>

                <td></td>

            </tr>

        @endif

    </tbody>

</table>


{{-- =========================================================
     AMÉNAGEMENTS ET MAINTENANCE
========================================================= --}}

<table
    class="data"
    style="margin-top:8px;"
>

    <thead>

        <tr>

            <th style="width:55%;">
                Aménagements et maintenance
            </th>

            <th style="width:15%;">
                Montant
            </th>

            <th style="width:30%;">
                Commentaires
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($amenagementsMaintenance as $depense)

            <tr>

                <td>
                    {{ $depense->categorie ?? '' }}
                </td>

                <td class="right">

                    {{ number_format(
                        $depense->montant_ttc ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                </td>

                <td>

                    {{ $depense->commentaire
                        ?? $depense->description
                        ?? '' }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="3"
                    class="center"
                >
                    Aucun aménagement ou maintenance enregistré.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =========================================================
     RECETTES
========================================================= --}}

<div class="section">
    Recettes
</div>


<table class="data">

    <thead>

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

            <th>
                Montant TTC
            </th>

            <th>
                Commentaires
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse(($reservations ?? []) as $reservation)

            <tr>

                {{-- CLIENT --}}

                <td>
                    {{ $reservation->client ?? '' }}
                </td>


                {{-- CHECK-IN --}}

                <td>

                    @if(!empty($reservation->check_in))

                        {{ \Carbon\Carbon::parse(
                            $reservation->check_in
                        )->format('d/m/Y') }}

                    @endif

                </td>


                {{-- CHECK-OUT --}}

                <td>

                    @if(!empty($reservation->check_out))

                        {{ \Carbon\Carbon::parse(
                            $reservation->check_out
                        )->format('d/m/Y') }}

                    @endif

                </td>


                {{-- NUITEES --}}

                <td class="center">

                    {{ $reservation->nombre_nuitees ?? 0 }}

                </td>


                {{-- MONTANT --}}

                <td class="right">

                    {{ number_format(
                        $reservation->montant_ttc ?? 0,
                        2,
                        ',',
                        ' '
                    ) }}

                </td>


                {{-- COMMENTAIRE --}}

                <td>

                    {{ $reservation->commentaire ?? '' }}

                </td>

            </tr>


        @empty

            <tr>

                <td
                    colspan="6"
                    class="center"
                >
                    Aucune réservation enregistrée.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =========================================================
     OCCUPATION
========================================================= --}}

<div class="section">
    Occupation
</div>


<table>

    <tr>

        <td style="width:75%;">

            Taux d'occupation

        </td>


        <td
            class="green center"
            style="
                width:25%;
                padding:4px;
            "
        >

            {{ $tauxOccupation ?? 0 }} %

        </td>

    </tr>

</table>


{{-- =========================================================
     RECAPITULATIF
========================================================= --}}

<div class="section">
    Récapitulatif
</div>


<table class="data">

    <tr>

        <td>
            Dépenses
        </td>

        <td class="right">

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

        <td>
            Recettes
        </td>

        <td class="right">

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

        <td>
            Taxe
        </td>

        <td class="right">

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

        <td>
            Aménagement et maintenance
        </td>

        <td class="right">

            {{ number_format(
                $amenagementTotal ?? 0,
                2,
                ',',
                ' '
            ) }}

            MAD

        </td>

    </tr>


    <tr class="total">

        <td>
            Montant net / résultat
        </td>

        <td class="right">

            {{ number_format(
                $solde ?? 0,
                2,
                ',',
                ' '
            ) }}

            MAD

        </td>

    </tr>

</table>


{{-- =========================================================
     JOURNAL DES INTERVENTIONS
========================================================= --}}

<div class="section">
    Journal des interventions
</div>


<table class="data">

    <thead>

        <tr>

            <th>
                Action
            </th>

            <th>
                Date
            </th>

            <th>
                Responsable
            </th>

            <th>
                Commentaire
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse(($interventions ?? []) as $intervention)

            <tr>

                <td>
                    {{ $intervention->action ?? '' }}
                </td>

                <td>
                    {{ $intervention->date ?? '' }}
                </td>

                <td>
                    {{ $intervention->responsable ?? '' }}
                </td>

                <td>
                    {{ $intervention->commentaire ?? '' }}
                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="4"
                    class="center"
                >
                    Aucune intervention enregistrée.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =========================================================
     ACTIONS D'AMÉLIORATION
========================================================= --}}

<div class="section">
    Actions d'amélioration
</div>


<table class="data">

    <thead>

        <tr>

            <th>
                Action
            </th>

            <th>
                Priorité
            </th>

            <th>
                Commentaires
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse(($actions ?? []) as $action)

            <tr
                class="{{ !empty($action->important) ? 'red-row' : '' }}"
            >

                <td>

                    {{ $action->action
                        ?? $action->description
                        ?? '' }}

                </td>


                <td class="center">

                    {{ $action->priorite
                        ?? $action->priorité
                        ?? '' }}

                </td>


                <td>

                    {{ $action->consequence
                        ?? $action->commentaire
                        ?? '' }}

                </td>

            </tr>


        @empty

            <tr>

                <td
                    colspan="3"
                    class="center"
                >
                    Aucune action d'amélioration enregistrée.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =========================================================
     FOOTER
========================================================= --}}

<div class="footer">
    <strong style="color:#e93223;">Stays</strong><strong style="color:#253b80;">&amp;Co.</strong>
</div>

</body>

</html>
