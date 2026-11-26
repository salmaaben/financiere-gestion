@extends('adminlte::page')

@section('title', 'Gestion des catégories')


@section('content_header')

<h1>
    <i class="fas fa-tags"></i>
    Gestion des catégories
</h1>

@stop



@section('content')


@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif



<a href="{{ route('categories.create') }}" 
   class="btn btn-success mb-3">

    Ajouter une catégorie

</a>



<div class="card">

<div class="card-body">


<table class="table table-bordered table-striped">


<thead>

<tr>

<th>ID</th>

<th>Nom</th>

<th>Description</th>

<th>Actions</th>

</tr>

</thead>


<tbody>


@foreach($categories as $category)


<tr>

<td>
{{ $category->id }}
</td>


<td>
{{ $category->name }}
</td>


<td>
{{ $category->description }}
</td>



<td>


<a href="{{ route('categories.show',$category->id) }}"
   class="btn btn-info btn-sm">

Voir

</a>



<a href="{{ route('categories.edit',$category->id) }}"
   class="btn btn-warning btn-sm">

Modifier

</a>




<form action="{{ route('categories.destroy',$category->id) }}"
      method="POST"
      style="display:inline">


@csrf

@method('DELETE')


<button type="submit"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Voulez-vous supprimer cette catégorie ?')">

Supprimer

</button>


</form>



</td>


</tr>


@endforeach


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