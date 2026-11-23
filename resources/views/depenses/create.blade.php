@extends('adminlte::page')

@section('title', 'Ajouter une dépense')

@section('content_header') <h1>Ajouter une dépense</h1>
@stop

@section('content')

@if ($errors->any()) <div class="alert alert-danger"> <strong> <i class="fas fa-exclamation-triangle"></i>
Merci de corriger les erreurs suivantes : </strong>
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>


@endif

<div class="card">

<div class="card-header">
    <h3 class="card-title">Nouvelle dépense</h3>
</div>

<form action="{{ route('expenses.store') }}" method="POST" novalidate>

    @csrf

    <div class="card-body">

        {{-- Numéro de pièce et type --}}
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">

                    <label>Numéro de pièce comptable</label>

                    <input type="text"
                           name="numero_piece"
                           class="form-control"
                           value="{{ old('numero_piece') }}"
                           required>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">

                    <label>Type</label>

                    <select name="type"
                            class="form-control"
                            required>

                        <option value="">Sélectionner</option>

                        <option value="Facture"
                            {{ old('type') == 'Facture' ? 'selected' : '' }}>
                            Facture
                        </option>

                        <option value="Reçu"
                            {{ old('type') == 'Reçu' ? 'selected' : '' }}>
                            Reçu
                        </option>

                        <option value="Note de frais"
                            {{ old('type') == 'Note de frais' ? 'selected' : '' }}>
                            Note de frais
                        </option>

                        <option value="Avoir"
                            {{ old('type') == 'Avoir' ? 'selected' : '' }}>
                            Avoir
                        </option>

                        <option value="Autre"
                            {{ old('type') == 'Autre' ? 'selected' : '' }}>
                            Autre
                        </option>

                    </select>

                </div>
            </div>

        </div>


        {{-- Paiement, montants et TVA --}}
        <div class="row">

            {{-- Mode de paiement --}}
            <div class="col-md-3">
                <div class="form-group">

                   <label>Mode de paiement</label>

<select name="mode_paiement" class="form-control" required>

    <option value="">Sélectionner</option>

    @foreach($modes as $mode)

        <option value="{{ $mode->libelle }}"
            {{ old('mode_paiement') == $mode->libelle ? 'selected' : '' }}>
            {{ $mode->libelle }}
        </option>

    @endforeach

</select>

                </div>
            </div>


            {{-- Montant TTC --}}
            <div class="col-md-3">
                <div class="form-group">

                    <label>Montant TTC</label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="montant_ttc"
                           id="montant_ttc"
                           class="form-control"
                           value="{{ old('montant_ttc') }}"
                           required>

                </div>
            </div>


            {{-- TVA --}}
            <div class="col-md-3">
                <div class="form-group">

                    <label>TVA</label>

                    <select name="tva_id"
                            id="tva_id"
                            class="form-control">

                        <option value="">Sélectionner une TVA</option>

                        @foreach($tvas as $tva)

                            <option value="{{ $tva->id }}"
                                    data-taux="{{ $tva->taux }}"
                                    {{ old('tva_id') == $tva->id ? 'selected' : '' }}>

                                {{ $tva->libelle }} - {{ $tva->taux }} %

                            </option>

                        @endforeach

                    </select>

                </div>
            </div>


            {{-- Montant TVA --}}
            <div class="col-md-3">
                <div class="form-group">

                    <label>Montant TVA</label>

                    <input type="number"
                           step="0.01"
                           name="montant_tva"
                           id="montant_tva"
                           class="form-control"
                           value="{{ old('montant_tva') }}"
                           readonly>

                </div>
            </div>

        </div>


        {{-- Devise, statut et fournisseur --}}
        <div class="row">

            {{-- Devise --}}
            <div class="col-md-4">
                <div class="form-group">

                    <label>Devise</label>

                    <select name="devise"
                            class="form-control">

                        <option value="MAD"
                            {{ old('devise', 'MAD') == 'MAD' ? 'selected' : '' }}>
                            MAD
                        </option>

                        <option value="EUR"
                            {{ old('devise') == 'EUR' ? 'selected' : '' }}>
                            EUR
                        </option>

                        <option value="USD"
                            {{ old('devise') == 'USD' ? 'selected' : '' }}>
                            USD
                        </option>

                    </select>

                </div>
            </div>


            {{-- Statut --}}
            <div class="col-md-4">
                <div class="form-group">

                    <label>Statut</label>

                    <select name="statut"
                            class="form-control">

                        <option value="">
                            Sélectionner un statut
                        </option>

                        @foreach($expenseStatuses as $status)

                            <option value="{{ $status->name }}"
                                {{ old('statut') == $status->name ? 'selected' : '' }}>

                                {{ $status->name }}

                            </option>

                        @endforeach

                    </select>

                </div>
            </div>


            {{-- Fournisseur --}}
            <div class="col-md-4">
                <div class="form-group">

                    <label>Fournisseur</label>

                    <select name="fournisseur"
                            class="form-control">

                        <option value="">
                            Sélectionner un fournisseur
                        </option>

                        @foreach($fournisseurs as $fournisseur)

                            <option value="{{ $fournisseur->name }}"
                                {{ old('fournisseur') == $fournisseur->name ? 'selected' : '' }}>

                                {{ $fournisseur->name }}

                            </option>

                        @endforeach

                    </select>

                </div>
            </div>

        </div>


        {{-- Catégorie et dates --}}
        <div class="row">

            {{-- Catégorie --}}
            <div class="col-md-6">
                <div class="form-group">

                    <label>Catégorie</label>

                    <select name="categorie"
                            class="form-control">

                        <option value="">
                            Sélectionner une catégorie
                        </option>

                        @foreach($categories as $categorie)

                            <option value="{{ $categorie->name }}"
                                {{ old('categorie') == $categorie->name ? 'selected' : '' }}>

                                {{ $categorie->name }}

                            </option>

                        @endforeach

                    </select>

                </div>
            </div>


            {{-- Dates --}}
            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label>Date</label>

                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="{{ old('date') }}"
                                   required>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label>Date d'échéance</label>

                            <input type="date"
                                   name="date_echeance"
                                   class="form-control"
                                   value="{{ old('date_echeance') }}">

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label>Date de valeur</label>

                            <input type="date"
                                   name="date_valeur"
                                   class="form-control"
                                   value="{{ old('date_valeur') }}">

                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- Libellé --}}
        <div class="form-group">

            <label>Libellé</label>

            <select name="libelle"
                    class="form-control">

                <option value="">
                    Sélectionner un libellé
                </option>

                @foreach($labels as $label)

                    <option value="{{ $label->name }}"
                        {{ old('libelle') == $label->name ? 'selected' : '' }}>

                        {{ $label->name }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Commentaire --}}
        <div class="form-group">

            <label>Commentaire</label>

            <textarea name="commentaire"
                      rows="4"
                      class="form-control">{{ old('commentaire') }}</textarea>

        </div>


        {{-- Lien justificatif --}}
        <div class="form-group">

            <label>Lien justificatif</label>

            <input type="url"
                   name="lien_justificatif"
                   class="form-control"
                   value="{{ old('lien_justificatif') }}"
                   placeholder="https://exemple.com/facture.pdf">

        </div>


        {{-- Lien justificatif comptable --}}
        <div class="form-group">

            <label>Lien justificatif comptable</label>

            <input type="url"
                   name="lien_justificatif_comptable"
                   class="form-control"
                   value="{{ old('lien_justificatif_comptable') }}"
                   placeholder="https://exemple.com/justificatif-comptable.pdf">

        </div>

    </div>


    {{-- Boutons --}}
    <div class="card-footer">

        <button type="submit"
                class="btn btn-success">

            <i class="fas fa-save"></i>
            Enregistrer

        </button>

        <a href="{{ route('expenses.index') }}"
           class="btn btn-secondary">

            Annuler

        </a>

    </div>

</form>


</div>

{{-- Calcul automatique de la TVA --}}

<script>

function calculerTVA() {

    const montantTTC =
        parseFloat(document.getElementById('montant_ttc').value) || 0;

    const selectTVA =
        document.getElementById('tva_id');

    const optionTVA =
        selectTVA.options[selectTVA.selectedIndex];

    const tauxTVA =
        parseFloat(optionTVA.getAttribute('data-taux')) || 0;

    let montantTVA = 0;

    if (montantTTC > 0 && tauxTVA > 0) {

        montantTVA =
            montantTTC * tauxTVA / (100 + tauxTVA);

    }

    document.getElementById('montant_tva').value =
        montantTVA.toFixed(2);
}


// Recalculer lorsque le montant TTC change
document.getElementById('montant_ttc').addEventListener(
    'input',
    calculerTVA
);


// Recalculer lorsque la TVA change
document.getElementById('tva_id').addEventListener(
    'change',
    calculerTVA
);


// Calcul initial en cas de valeur déjà sélectionnée
calculerTVA();

</script>

@stop
