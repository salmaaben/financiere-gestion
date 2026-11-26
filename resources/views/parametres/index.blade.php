
@extends('adminlte::page')

@section('title', 'Paramètres')

@section('content_header')

<h1>
    <i class="fas fa-cogs"></i>
    Paramètres
</h1>

@stop

@section('content')

<div class="row">

    <!-- Utilisateurs -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-users fa-3x text-primary mb-3"></i>

                <h5>Gestion des utilisateurs</h5>

                <p class="text-muted">

                    Ajouter, modifier ou supprimer des utilisateurs.

                </p>

<a href="{{ route('users.index') }}" class="btn btn-primary btn-block">
    Ouvrir
</a>
            </div>

        </div>

    </div>


    <!-- Catégories -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-tags fa-3x text-success mb-3"></i>

                <h5>Gestion des catégories</h5>

                <p class="text-muted">

                    Gérer les catégories.

                </p>

               <a href="{{ route('categories.index') }}"
   class="btn btn-success btn-block">

    Ouvrir

</a>

            </div>

        </div>

    </div>


    <!-- Libellés -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-file-signature fa-3x text-info mb-3"></i>

                <h5>Gestion des libellés</h5>

                <p class="text-muted">

                    Gérer les libellés.

                </p>

                <a href="{{ route('labels.index') }}"
                   class="btn btn-info btn-block">

                    Ouvrir

                </a>

            </div>

        </div>

    </div>


    <!-- Fournisseurs -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-truck fa-3x text-warning mb-3"></i>

                <h5>Gestion des fournisseurs</h5>

                <p class="text-muted">

                    Gérer les fournisseurs.

                </p>

   <a href="{{ route('fournisseurs.index') }}"
   class="btn btn-warning btn-block">

    Ouvrir

</a>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <!-- Clients -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-user-friends fa-3x text-danger mb-3"></i>

                <h5>Gestion des clients</h5>


<p class="card-text">
    Gérer les clients.
</p>

<a href="{{ route('clients.index') }}"
   class="btn btn-danger btn-block">

    Ouvrir

</a>

            </div>

        </div>

    </div>


    <!-- Statut revenus -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-money-check-alt fa-3x text-success mb-3"></i>

                <h5>Statut des revenus</h5>

                <p class="text-muted">

                    Gérer les statuts.

                </p>

                <a href="{{ route('revenue-status.index') }}"
   class="btn btn-success btn-block">
    Ouvrir
</a>

            </div>

        </div>

    </div>


    <!-- Statut dépenses -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

               <i class="fas fa-file-invoice-dollar fa-3x text-danger mb-3"></i>

<h5>Statut des dépenses</h5>

<p class="text-muted">
    Gérer les statuts.
</p>

<a href="{{ route('expense-status.index') }}"
   class="btn btn-danger btn-block">
    Ouvrir
</a>

            </div>

        </div>

    </div>


    <!-- Types de pièces -->

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <i class="fas fa-file-invoice fa-3x text-dark mb-3"></i>

                <h5>Types de pièces comptables</h5>

                <p class="text-muted">

                    Gérer les types.

                </p>

                <a href="{{ route('type-pieces.index') }}"
   class="btn btn-dark btn-block">
                    Ouvrir

                </a>

            </div>

        </div>

    </div>
    <!-- TVA -->

<div class="col-md-3 mb-4">

    <div class="card shadow-sm">

        <div class="card-body text-center">

            <i class="fas fa-percent fa-3x text-primary mb-3"></i>

            <h5>Gestion des TVA</h5>

            <p class="text-muted">

                Gérer les taux de TVA.

            </p>

            <a href="{{ route('tva.index') }}"
               class="btn btn-primary btn-block">

                Ouvrir

            </a>

        </div>

    </div>

</div>
<!-- Modes de paiement -->

<div class="col-md-3 mb-4">

    <div class="card shadow-sm">

        <div class="card-body text-center">

            <i class="fas fa-credit-card fa-3x text-info mb-3"></i>

            <h5>Gestion des modes de paiement</h5>

            <p class="text-muted">
                Gérer les modes de paiement.
            </p>

            <a href="{{ route('modes-paiement.index') }}"
               class="btn btn-info btn-block">
                Ouvrir
            </a>

        </div>

    </div>

</div>
</div>

@stop