@extends('adminlte::page')

@section('title', 'Ajouter un revenu')

@section('content_header')
    <h1>Ajouter un revenu</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>
            <i class="fas fa-exclamation-triangle"></i>
            Merci de corriger les erreurs suivantes :
        </strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Nouveau revenu</h3>
    </div>

    <form action="{{ route('revenus.store') }}" method="POST" novalidate enctype="multipart/form-data">

        @csrf

        <div class="card-body">

            {{-- Numéro de pièce et type de pièce --}}
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero_piece">
                            Numéro de pièce comptable
                        </label>

                        <input
                            type="text"
                            name="numero_piece"
                            id="numero_piece"
                            class="form-control"
                            value="{{ old('numero_piece') }}"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_piece">
                            Type de pièce
                        </label>

                        <select name="type_piece" id="type_piece" class="form-control">
                            <option value="">
                                Sélectionner un type
                            </option>

                            @foreach($typePieces as $typePiece)

                                <option
                                    value="{{ $typePiece->name }}"
                                    {{ old('type_piece') == $typePiece->name ? 'selected' : '' }}
                                >
                                    {{ $typePiece->name }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>

            </div>


            {{-- Montants --}}
            <div class="row">

                {{-- Montant TTC --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="montant_ttc">
                            Montant TTC
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="montant_ttc"
                            id="montant_ttc"
                            class="form-control"
                            value="{{ old('montant_ttc') }}"
                            placeholder="0.00"
                        >

                    </div>
                </div>


                {{-- TVA --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="tva_id">
                            TVA
                        </label>

                        <select
                            name="tva_id"
                            id="tva_id"
                            class="form-control"
                        >

                            <option value="">
                                -- Sélectionner une TVA --
                            </option>

                            @foreach($tvas as $tva)

                                <option
                                    value="{{ $tva->id }}"
                                    data-taux="{{ $tva->taux }}"
                                    {{ old('tva_id') == $tva->id ? 'selected' : '' }}
                                >
                                    {{ $tva->taux }} %
                                </option>

                            @endforeach

                        </select>

                        @error('tva_id')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>
                </div>


                {{-- Montant TVA --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="montant_tva">
                            Montant TVA
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="montant_tva"
                            id="montant_tva"
                            class="form-control"
                            value="{{ old('montant_tva') }}"
                            placeholder="0.00"
                            readonly
                        >

                    </div>
                </div>

            </div>


            {{-- Devise, statut, client --}}
            <div class="row">

                {{-- Devise --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="devise">
                            Devise
                        </label>

                        <select
                            name="devise"
                            id="devise"
                            class="form-control"
                        >

                            <option value="MAD"
                                {{ old('devise', 'MAD') == 'MAD' ? 'selected' : '' }}>
                                MAD
                            </option>

                        </select>

                    </div>
                </div>


                {{-- Statut --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="statut">
                            Statut
                        </label>

                        <select
                            name="statut"
                            id="statut"
                            class="form-control"
                        >

                            <option value="">
                                Sélectionner un statut
                            </option>

                            @foreach($revenueStatuses as $status)

                                <option
                                    value="{{ $status->name }}"
                                    {{ old('statut') == $status->name ? 'selected' : '' }}
                                >
                                    {{ $status->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>
                </div>

{{-- Mode de paiement --}}
<div class="col-md-4">
    <div class="form-group">

        <label for="mode_paiement">Mode de paiement</label>

        <select name="mode_paiement"
                id="mode_paiement"
                class="form-control">

            <option value="">Sélectionner un mode de paiement</option>

            @foreach($modes as $mode)
                <option value="{{ $mode->libelle }}"
                    {{ old('mode_paiement') == $mode->libelle ? 'selected' : '' }}>
                    {{ $mode->libelle }}
                </option>
            @endforeach

        </select>

    </div>
</div>
                {{-- Client --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="client">
                            Client
                        </label>

                        <select
                            name="client"
                            id="client"
                            class="form-control"
                        >

                            <option value="">
                                Sélectionner un client
                            </option>

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->name }}"
                                    {{ old('client') == $client->name ? 'selected' : '' }}
                                >
                                    {{ $client->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>
                </div>

            </div>


            {{-- Catégorie --}}
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">

                        <label for="categorie">
                            Catégorie
                        </label>

                        <select
                            name="categorie"
                            id="categorie"
                            class="form-control"
                        >

                            <option value="">
                                Sélectionner une catégorie
                            </option>

                            @foreach($categories as $categorie)

                                <option
                                    value="{{ $categorie->name }}"
                                    {{ old('categorie') == $categorie->name ? 'selected' : '' }}
                                >
                                    {{ $categorie->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>
                </div>

            </div>


            {{-- Libellé --}}
            <div class="form-group">

                <label for="libelle">
                    Libellé
                </label>

                <select
                    name="libelle"
                    id="libelle"
                    class="form-control"
                >

                    <option value="">
                        Sélectionner un libellé
                    </option>

                    @foreach($labels as $label)

                        <option
                            value="{{ $label->name }}"
                            {{ old('libelle') == $label->name ? 'selected' : '' }}
                        >
                            {{ $label->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Dates --}}
            <div class="row">

                {{-- Date --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="date">
                            Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            id="date"
                            class="form-control"
                            value="{{ old('date') }}"
                        >

                    </div>
                </div>


                {{-- Date échéance --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="date_echeance">
                            Date d'échéance
                        </label>

                        <input
                            type="date"
                            name="date_echeance"
                            id="date_echeance"
                            class="form-control"
                            value="{{ old('date_echeance') }}"
                        >

                    </div>
                </div>


                {{-- Date valeur --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="date_valeur">
                            Date de valeur
                        </label>

                        <input
                            type="date"
                            name="date_valeur"
                            id="date_valeur"
                            class="form-control"
                            value="{{ old('date_valeur') }}"
                        >

                    </div>
                </div>

            </div>


            {{-- Commentaire --}}
            <div class="form-group">

                <label for="commentaire">
                    Commentaire
                </label>

                <textarea
                    name="commentaire"
                    id="commentaire"
                    rows="4"
                    class="form-control"
                >{{ old('commentaire') }}</textarea>

            </div>


            {{-- Justificatif --}}
            <div class="form-group">

                <label for="lien_justificatif">
                    Lien du justificatif
                </label>

                <input
                    type="url"
                    name="lien_justificatif"
                    id="lien_justificatif"
                    class="form-control"
                    value="{{ old('lien_justificatif') }}"
                    placeholder="https://exemple.com/justificatif.pdf"
                >

            </div>


            {{-- Informations séjour --}}
            <div class="row">

                {{-- Check-in --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="check_in">
                            Check-in
                        </label>

                        <input
                            type="date"
                            name="check_in"
                            id="check_in"
                            class="form-control"
                            value="{{ old('check_in') }}"
                        >

                    </div>
                </div>


                {{-- Check-out --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="check_out">
                            Check-out
                        </label>

                        <input
                            type="date"
                            name="check_out"
                            id="check_out"
                            class="form-control"
                            value="{{ old('check_out') }}"
                        >

                    </div>
                </div>


                {{-- Nombre de nuitées --}}
                <div class="col-md-4">
                    <div class="form-group">

                        <label for="nombre_nuitees">
                            Nombre de nuitées
                        </label>

                        <input
                            type="number"
                            name="nombre_nuitees"
                            id="nombre_nuitees"
                            class="form-control"
                            min="1"
                            value="{{ old('nombre_nuitees') }}"
                        >

                    </div>
                </div>

            </div>

        </div>


        {{-- Boutons --}}
        <div class="card-footer">

            <button
                type="submit"
                class="btn btn-success"
            >
                <i class="fas fa-save"></i>
                Enregistrer
            </button>

            <a
                href="{{ route('revenus.index') }}"
                class="btn btn-secondary"
            >
                Annuler
            </a>

        </div>

    </form>

</div>


{{-- Calcul automatique de la TVA --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const montantTtc = document.getElementById('montant_ttc');
    const tvaSelect = document.getElementById('tva_id');
    const montantTva = document.getElementById('montant_tva');


    function calculerTva() {

        // Récupération du montant TTC
        const ttc = parseFloat(montantTtc.value) || 0;

        // Récupération de l'option TVA sélectionnée
        const selectedOption =
            tvaSelect.options[tvaSelect.selectedIndex];

        // Récupération du taux depuis data-taux
        const taux =
            parseFloat(selectedOption.getAttribute('data-taux')) || 0;


        // Si le montant TTC ou le taux est nul
        if (ttc <= 0 || taux <= 0) {

            montantTva.value = '0.00';

            return;
        }


        // Calcul de la TVA incluse dans le TTC
        //
        // Exemple :
        // TTC = 1200
        // TVA = 20%
        //
        // TVA = 1200 × 20 / (100 + 20)
        // TVA = 200
        //
        const tva = (ttc * taux) / (100 + taux);


        // Affichage avec 2 décimales
        montantTva.value = tva.toFixed(2);
    }


    // Recalcul lorsque le montant TTC change
    montantTtc.addEventListener('input', calculerTva);


    // Recalcul lorsque la TVA change
    tvaSelect.addEventListener('change', calculerTva);


    // Calcul initial
    calculerTva();

});

</script>

@stop