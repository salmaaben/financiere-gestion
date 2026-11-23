
@extends('adminlte::page')

@section('title', 'Modifier un revenu')

@section('content_header')
    <h1>
        <i class="fas fa-edit"></i>
        Modifier un revenu
    </h1>
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
    <div class="card-body">

        <form method="POST" action="{{ route('revenus.update', $revenu->id) }}">
            @csrf
            @method('PUT')

            {{-- Numéro et type de pièce --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero_piece">Numéro de pièce</label>
                        <input type="text"
                               id="numero_piece"
                               name="numero_piece"
                               class="form-control"
                               value="{{ old('numero_piece', $revenu->numero_piece) }}">
                    </div>
                </div>

                <div class="col-md-6">
    <div class="form-group">
        <label for="type_piece">Type de pièce</label>

        <select name="type_piece" id="type_piece" class="form-control">
            <option value="">Sélectionner un type</option>

            @foreach($typePieces as $typePiece)
                <option value="{{ $typePiece->name }}"
                    {{ old('type_piece', $revenu->type_piece) == $typePiece->name ? 'selected' : '' }}>
                    {{ $typePiece->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
            </div>

            {{-- Montants --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="montant_ttc">Montant TTC</label>
                        <input type="number"
                               step="0.01"
                               id="montant_ttc"
                               name="montant_ttc"
                               class="form-control"
                               value="{{ old('montant_ttc', $revenu->montant_ttc) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tva_id">TVA</label>
                        <select name="tva_id" id="tva_id" class="form-control">
                            <option value="">-- Sélectionner une TVA --</option>
                            @foreach($tvas as $tva)
                                <option value="{{ $tva->id }}"
                                    {{ old('tva_id', $revenu->tva_id) == $tva->id ? 'selected' : '' }}>
                                    {{ $tva->name }} - {{ $tva->taux }} %
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="montant_tva">Montant TVA</label>
                        <input type="number"
                               step="0.01"
                               id="montant_tva"
                               name="montant_tva"
                               class="form-control"
                               value="{{ old('montant_tva', $revenu->montant_tva) }}">
                    </div>
                </div>
            </div>

            {{-- Devise, statut et mode de paiement --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="devise">Devise</label>
                        <select name="devise" id="devise" class="form-control">
                            @foreach(['MAD', 'EUR', 'USD'] as $devise)
                                <option value="{{ $devise }}"
                                    {{ old('devise', $revenu->devise) == $devise ? 'selected' : '' }}>
                                    {{ $devise }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select name="statut" id="statut" class="form-control">
                            <option value="">-- Sélectionner un statut --</option>
                            @foreach($revenueStatus as $status)
                                <option value="{{ $status->name }}"
                                    {{ old('statut', $revenu->statut) == $status->name ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mode_paiement">Mode de paiement</label>
                        <select name="mode_paiement" id="mode_paiement" class="form-control">
                            <option value="">Sélectionner un mode de paiement</option>
                            @foreach($modes as $mode)
                                <option value="{{ $mode->libelle }}"
                                    {{ old('mode_paiement', $revenu->mode_paiement) == $mode->libelle ? 'selected' : '' }}>
                                    {{ $mode->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Client et catégorie --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client">Client</label>
                        <select name="client" id="client" class="form-control">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->name }}"
                                    {{ old('client', $revenu->client) == $client->name ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie" class="form-control">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->name }}"
                                    {{ old('categorie', $revenu->categorie) == $categorie->name ? 'selected' : '' }}>
                                    {{ $categorie->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Libellé --}}
            <div class="form-group">
                <label for="libelle">Libellé</label>
                <select name="libelle" id="libelle" class="form-control">
                    <option value="">Sélectionner un libellé</option>
                    @foreach($labels as $label)
                        <option value="{{ $label->name }}"
                            {{ old('libelle', $revenu->libelle) == $label->name ? 'selected' : '' }}>
                            {{ $label->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dates --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date"
                               id="date"
                               name="date"
                               class="form-control"
                               value="{{ old('date', $revenu->date) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date_echeance">Date d'échéance</label>
                        <input type="date"
                               id="date_echeance"
                               name="date_echeance"
                               class="form-control"
                               value="{{ old('date_echeance', $revenu->date_echeance) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date_valeur">Date de valeur</label>
                        <input type="date"
                               id="date_valeur"
                               name="date_valeur"
                               class="form-control"
                               value="{{ old('date_valeur', $revenu->date_valeur) }}">
                    </div>
                </div>
            </div>

            {{-- Commentaire et justificatif --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea name="commentaire"
                                  id="commentaire"
                                  class="form-control"
                                  rows="4">{{ old('commentaire', $revenu->commentaire) }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="lien_justificatif">Lien justificatif</label>
                        <input type="url"
                               id="lien_justificatif"
                               name="lien_justificatif"
                               class="form-control"
                               value="{{ old('lien_justificatif', $revenu->lien_justificatif) }}">
                    </div>
                </div>
            </div>

            {{-- Informations de séjour --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="check_in">Check-in</label>
                        <input type="date"
                               id="check_in"
                               name="check_in"
                               class="form-control"
                               value="{{ old('check_in', $revenu->check_in) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="check_out">Check-out</label>
                        <input type="date"
                               id="check_out"
                               name="check_out"
                               class="form-control"
                               value="{{ old('check_out', $revenu->check_out) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre_nuitees">Nombre de nuitées</label>
                        <input type="number"
                               id="nombre_nuitees"
                               name="nombre_nuitees"
                               class="form-control"
                               value="{{ old('nombre_nuitees', $revenu->nombre_nuitees) }}">
                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>
                Mettre à jour
            </button>

            <a href="{{ route('revenus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Annuler
            </a>

        </form>
    </div>
</div>

@stop
