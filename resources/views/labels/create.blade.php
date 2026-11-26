@extends('adminlte::page')

@section('title','Ajouter un libellé')

@section('content_header')

<h1>
    <i class="fas fa-plus"></i>
    Ajouter un libellé
</h1>

@stop

@section('content')

<div class="card">

<div class="card-body">

<form method="POST"
      action="{{ route('labels.store') }}">

@csrf

<div class="form-group">

<label>
Nom du libellé
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

<button class="btn btn-success">

Enregistrer

</button>

<a href="{{ route('labels.index') }}"
   class="btn btn-secondary">

Annuler

</a>

</form>

</div>

</div>

@stop