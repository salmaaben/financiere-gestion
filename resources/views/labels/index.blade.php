@extends('adminlte::page')

@section('title','Gestion des libellés')

@section('content_header')

<h1>
    <i class="fas fa-tags"></i>
    Gestion des libellés
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

<a href="{{ route('labels.create') }}"
   class="btn btn-success">

<i class="fas fa-plus"></i>

Ajouter un libellé

</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th width="80">ID</th>

<th>Libellé</th>


<th width="180">Actions</th>

</tr>

</thead>

<tbody>

@forelse($labels as $label)

<tr>

<td>{{ $label->id }}</td>

<td>{{ $label->name }}</td>

<td>

<a href="{{ route('labels.edit',$label->id) }}"
   class="btn btn-primary btn-sm">

<i class="fas fa-edit"></i>

</a>

<form action="{{ route('labels.destroy',$label->id) }}"
      method="POST"
      style="display:inline;">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
        onclick="return confirm('Supprimer ce libellé ?')">

<i class="fas fa-trash"></i>

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center">

Aucun libellé trouvé.

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