@extends('adminlte::page')

@section('title','Modifier un client')

@section('content_header')

<h1>

<i class="fas fa-edit"></i>

Modifier un client

</h1>

@stop

@section('content')

<div class="card">

<div class="card-body">

<form method="POST"
      action="{{ route('clients.update',$client->id) }}">

@csrf
@method('PUT')

<div class="form-group">

<label>

Nom du client

</label>

<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$client->name) }}">

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
          rows="4">{{ old('description',$client->description) }}</textarea>

</div>

<button class="btn btn-success">

Mettre à jour

</button>

<a href="{{ route('clients.index') }}"
   class="btn btn-secondary">

Annuler

</a>

</form>

</div>

</div>

@stop