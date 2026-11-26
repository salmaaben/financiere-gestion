@extends('adminlte::page')

@section('title','Modifier un libellé')

@section('content_header')

<h1>
    <i class="fas fa-edit"></i>
    Modifier un libellé
</h1>

@stop

@section('content')

<div class="card">

<div class="card-body">

<form method="POST"
      action="{{ route('labels.update',$label->id) }}">

@csrf
@method('PUT')

<div class="form-group">

<label>
Nom du libellé
</label>

<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$label->name) }}">

@error('name')

<div class="text-danger">

{{ $message }}

</div>

@enderror

</div>


<button class="btn btn-success">

Mettre à jour

</button>

<a href="{{ route('labels.index') }}"
   class="btn btn-secondary">

Annuler

</a>

</form>

</div>

</div>

@stop