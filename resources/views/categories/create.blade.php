@extends('adminlte::page')


@section('title','Ajouter catégorie')


@section('content_header')

<h1>
    <i class="fas fa-plus"></i>
    Ajouter une catégorie
</h1>

@stop



@section('content')


<div class="card">


<div class="card-body">


<form method="POST"
      action="{{ route('categories.store') }}">


@csrf



<div class="form-group">

<label>
Nom de la catégorie
</label>


<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name') }}">


@error('name')

<div class="text-danger">
{{ $message }}
</div>

@enderror


</div>




<div class="form-group">

<label>
Description
</label>


<textarea name="description"
          class="form-control"
          rows="4">{{ old('description') }}</textarea>


</div>




<button class="btn btn-success">

Enregistrer

</button>



<a href="{{ route('categories.index') }}"
   class="btn btn-secondary">

Annuler

</a>



</form>


</div>


</div>



@stop