@extends('adminlte::page')

@section('title','Gestion des clients')

@section('content_header')

<h1>
    <i class="fas fa-users"></i>
    Gestion des clients
</h1>

@stop

@section('content')

@if(session('success'))

<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>

@endif

<div class="card">

<div class="card-header">

<a href="{{ route('clients.create') }}"
   class="btn btn-success">

<i class="fas fa-plus"></i>

Nouveau client

</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th width="80">ID</th>

<th>Nom</th>

<th>Description</th>

<th width="180">Actions</th>

</tr>

</thead>

<tbody>

@forelse($clients as $client)

<tr>

<td>{{ $client->id }}</td>

<td>{{ $client->name }}</td>

<td>{{ $client->description }}</td>

<td>

<a href="{{ route('clients.edit',$client->id) }}"
   class="btn btn-primary btn-sm">

<i class="fas fa-edit"></i>

Modifier

</a>

<form action="{{ route('clients.destroy',$client->id) }}"
      method="POST"
      style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
        onclick="return confirm('Supprimer ce client ?')">

<i class="fas fa-trash"></i>

Supprimer

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center">

Aucun client trouvé.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>
<a href="{{ route('parametres.index') }}"
   class="btn btn-secondary">

    <i class="fas fa-arrow-left"></i>
    Retour

</a>
@stop