php@extends('adminlte::page')

@section('title','Modifier un statut')

@section('content_header')

<h1>

    <i class="fas fa-edit"></i>

    Modifier un statut de revenu

</h1>

@stop

@section('content')

<div class="card">

<div class="card-body">

<form method="POST"
      action="{{ route('revenue-status.update',$revenueStatus->id) }}">

@csrf
@method('PUT')

<div class="form-group">

<label>Nom du statut</label>

<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$revenueStatus->name) }}">

@error('name')

<div class="text-danger">

{{ $message }}

</div>

@enderror

</div>

<div class="form-group">

<label>Description</label>

<textarea name="description"
          class="form-control"
          rows="4">{{ old('description',$revenueStatus->description) }}</textarea>

</div>

<button class="btn btn-success">

<i class="fas fa-save"></i>

Mettre à jour

</button>

<a href="{{ route('revenue-status.index') }}"
   class="btn btn-secondary">

Annuler

</a>

</form>

</div>

</div>

@stop