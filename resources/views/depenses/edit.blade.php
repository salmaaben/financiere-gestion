
@extends('adminlte::page')

@section('title', 'Modifier une dépense')

@section('content_header')
    <h1>Modifier une dépense</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informations de la dépense</h3>
    </div>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            {{-- 1. Informations comptables --}}
            <h5 class="mb-3 text-primary">Informations comptables</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Numéro de pièce comptable</label>
                        <input type="text" name="numero_piece" class="form-control"
                               value="{{ old('numero_piece', $expense->numero_piece) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            @foreach(['Facture', 'Reçu', 'Note de frais', 'Avoir', 'Autre'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('type', $expense->type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="statut" class="form-control">
                            @foreach($expenseStatuses as $status)
                                <option value="{{ $status->name }}"
                                    {{ old('statut', $expense->statut) == $status->name ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            {{-- 2. Paiement et montants --}}
            <h5 class="mb-3 text-primary">Paiement et montants</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Mode de paiement</label>
                        <select name="mode_paiement" class="form-control">
                            <option value="">Sélectionner un mode</option>
                            @foreach($modes as $mode)
                                <option value="{{ $mode->libelle }}"
                                    {{ old('mode_paiement', $expense->mode_paiement) == $mode->libelle ? 'selected' : '' }}>
                                    {{ $mode->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Devise</label>
                        <select name="devise" class="form-control">
                            @foreach(['MAD', 'EUR', 'USD'] as $devise)
                                <option value="{{ $devise }}"
                                    {{ old('devise', $expense->devise) == $devise ? 'selected' : '' }}>
                                    {{ $devise }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Montant TTC</label>
                        <input type="number" step="0.01" name="montant_ttc"
                               id="montant_ttc" class="form-control"
                               value="{{ old('montant_ttc', $expense->montant_ttc) }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Montant TVA</label>
                        <input type="number" step="0.01" name="montant_tva"
                               id="montant_tva" class="form-control"
                               value="{{ old('montant_tva', $expense->montant_tva) }}"
                               readonly>
                    </div>
                </div>
            </div>

            <hr>

            {{-- 3. Informations fournisseur --}}
            <h5 class="mb-3 text-primary">Informations fournisseur</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fournisseur</label>
                        <select name="fournisseur" class="form-control">
                            <option value="">Sélectionner un fournisseur</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->name }}"
                                    {{ old('fournisseur', $expense->fournisseur) == $fournisseur->name ? 'selected' : '' }}>
                                    {{ $fournisseur->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select name="categorie" class="form-control">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->name }}"
                                    {{ old('categorie', $expense->categorie) == $categorie->name ? 'selected' : '' }}>
                                    {{ $categorie->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Libellé</label>
                        <select name="libelle" class="form-control">
                            <option value="">Sélectionner un libellé</option>
                            @foreach($labels as $label)
                                <option value="{{ $label->name }}"
                                    {{ old('libelle', $expense->libelle) == $label->name ? 'selected' : '' }}>
                                    {{ $label->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            {{-- 4. Dates --}}
            <h5 class="mb-3 text-primary">Dates</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control"
                               value="{{ old('date', $expense->date) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date d'échéance</label>
                        <input type="date" name="date_echeance" class="form-control"
                               value="{{ old('date_echeance', $expense->date_echeance) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date de valeur</label>
                        <input type="date" name="date_valeur" class="form-control"
                               value="{{ old('date_valeur', $expense->date_valeur) }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- 5. Justificatifs et commentaires --}}
            <h5 class="mb-3 text-primary">Justificatifs et commentaires</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lien justificatif</label>
                        <input type="url" name="lien_justificatif" class="form-control"
                               value="{{ old('lien_justificatif', $expense->lien_justificatif) }}"
                               placeholder="https://exemple.com/facture.pdf">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lien justificatif comptable</label>
                        <input type="url" name="lien_justificatif_comptable" class="form-control"
                               value="{{ old('lien_justificatif_comptable', $expense->lien_justificatif_comptable) }}"
                               placeholder="https://exemple.com/justificatif-comptable.pdf">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Commentaire</label>
                <textarea name="commentaire" rows="3" class="form-control">{{ old('commentaire', $expense->commentaire) }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Mettre à jour
            </button>

            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('montant_ttc').addEventListener('input', function () {
    let montant = parseFloat(this.value);

    if (!isNaN(montant)) {
        let tva = montant * 20 / 120;
        document.getElementById('montant_tva').value = tva.toFixed(2);
    } else {
        document.getElementById('montant_tva').value = '';
    }
});
</script>

@stop
