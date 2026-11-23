
@extends('adminlte::page')

@section('title', 'Tableau de bord')

@section('content_header')
    <h1>
        <i class="fas fa-chart-line text-primary"></i>
        Tableau de bord financier
    </h1>
@stop

@section('content')

{{-- POURCENTAGE DU REVENU DEPENSE --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-uppercase text-secondary">
                    Pourcentage du revenu dépensé
                </h5>
            </div>

            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div style="width:100%; height:38px;
                            background:#e9ecef;
                            border:1px solid #cfcfcf;
                            border-radius:3px;
                            overflow:hidden;">

                            <div style="width:{{ min($pourcentage,100) }}%;
                                height:100%;
                                background:#4b7d22;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 text-center">
                        <span style="font-size:34px;
                            color:#4b7d22;
                            font-weight:bold;">
                            {{ number_format($pourcentage,0) }} %
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- INDICATEURS FINANCIERS --}}
<div class="row">

    {{-- REVENUS --}}
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($revenuTotal,2,',',' ') }} MAD</h3>
                <p>Revenu Total</p>
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
                <h3>{{ number_format($depenseTotale,2,',',' ') }} MAD</h3>
                <p>Dépenses Totales</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    {{-- SOLDE --}}
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($solde,2,',',' ') }} MAD</h3>
                <p>Solde</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    {{-- CREANCES --}}
    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ number_format($creance,2,',',' ') }} MAD</h3>
                <p>Créances à encaisser</p>
            </div>
            <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
        </div>
    </div>

    {{-- TVA REVENUS --}}
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($tvaRevenu,2,',',' ') }} MAD</h3>
                <p>TVA (Revenus)</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>

    {{-- TVA DEPENSES --}}
    <div class="col-md-3">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ number_format($tvaDepense,2,',',' ') }} MAD</h3>
                <p>TVA (Dépenses)</p>
            </div>
            <div class="icon">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>

</div>


{{-- TRESORERIE ET IMPOTS --}}
<div class="row">

    {{-- TRESORERIE --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-success text-white">
                <strong>Trésorerie</strong>
            </div>

            <div class="card-body">
                <table class="table table-bordered">

                    <tr>
                        <th>Caisse</th>
                        <td>{{ number_format($caisse,2,',',' ') }} MAD</td>
                    </tr>

                    <tr>
                        <th>Banque</th>
                        <td>{{ number_format($banque,2,',',' ') }} MAD</td>
                    </tr>

                    <tr class="table-success">
                        <th>Total Trésorerie</th>
                        <th>{{ number_format($totalTreso,2,',',' ') }} MAD</th>
                    </tr>

                </table>
            </div>
        </div>
    </div>


    {{-- IMPOTS --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-warning">
                <strong>Impôts</strong>
            </div>

            <div class="card-body">
                <table class="table table-bordered">

                    <tr>
                        <th>IS</th>
                        <td>{{ number_format($is,2,',',' ') }} MAD</td>
                    </tr>

                    <tr>
                        <th>TVA sur Revenus</th>
                        <td>{{ number_format($tvaRevenu,2,',',' ') }} MAD</td>
                    </tr>

                    <tr>
                        <th>TVA sur Dépenses</th>
                        <td>{{ number_format($tvaDepense,2,',',' ') }} MAD</td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

</div>


{{-- SUIVI DES DETTES ET CREANCES --}}
<div class="row mt-4">

    {{-- DETTES --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-danger text-white">
                <strong>
                    <i class="fas fa-file-invoice"></i>
                    Suivi des dettes
                </strong>
            </div>

            <div class="card-body">

                <h4 class="text-danger mb-3">
                    {{ number_format($dette,2,',',' ') }} MAD
                </h4>

                <table class="table table-bordered">

                    <tr>
                        <th>À payer</th>
                        <td>
                            {{ number_format($detteAPayer,2,',',' ') }} MAD
                        </td>
                    </tr>

                    <tr>
                        <th>En retard</th>
                        <td class="text-danger">
                            {{ number_format($detteEnRetard,2,',',' ') }} MAD
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </div>


    {{-- CREANCES --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <strong>
                    <i class="fas fa-hand-holding-usd"></i>
                    Suivi des créances
                </strong>
            </div>

            <div class="card-body">

                <h4 class="text-primary mb-3">
                    {{ number_format($creance,2,',',' ') }} MAD
                </h4>

                <table class="table table-bordered">

                    <tr>
                        <th>À encaisser</th>
                        <td>
                            {{ number_format($creanceAEncaisser,2,',',' ') }} MAD
                        </td>
                    </tr>

                    <tr>
                        <th>En retard</th>
                        <td class="text-danger">
                            {{ number_format($creanceEnRetard,2,',',' ') }} MAD
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </div>

</div>


{{-- GRAPHIQUE --}}
<div class="row mt-4">

    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-light">
                <strong>Résumé financier</strong>
            </div>

            <div class="card-body">
                <canvas id="resumeChart" height="250"></canvas>
            </div>

        </div>
    </div>

</div>

@stop


@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('resumeChart');

new Chart(ctx, {

    type: 'bar',

    data: {
        labels: ['Revenus', 'Dépenses'],

        datasets: [{
            data: [
                {{ $revenuTotal }},
                {{ $depenseTotale }}
            ],

            backgroundColor: [
                '#467a1f',
                '#b31263'
            ],

            borderWidth: 1
        }]
    },

    options: {

        responsive: true,
        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            },

            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.parsed.y.toLocaleString() + ' MAD';
                    }
                }
            }
        },

        scales: {

            y: {
                beginAtZero: true,

                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + ' MAD';
                    }
                }
            }
        }
    }
});

</script>

@stop
