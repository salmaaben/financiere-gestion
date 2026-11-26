@extends('adminlte::page')

@section('title', 'Détails de la TVA')

@section('content_header')

<h1>
    <i class="fas fa-percent"></i>
    Détails de la TVA
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Informations sur la TVA
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label>Libellé</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $tva->libelle }}"
                           readonly>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label>Taux de TVA</label>

                    <div class="input-group">

                        <input type="text"
                               class="form-control"
                               value="{{ $tva->taux }}"
                               readonly>

                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div class="form-group">
            <label>ID</label>

            <input type="text"
                   class="form-control"
                   value="{{ $tva->id }}"
                   readonly>
        </div>

    </div>

    <div class="card-footer">

        <a href="{{ route('tva.index') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Retour

        </a>

        <a href="{{ route('tva.edit', $tva->id) }}"
           class="btn btn-warning">

            <i class="fas fa-edit"></i>
            Modifier

        </a>

    </div>

</div>

@stop