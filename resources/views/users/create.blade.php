@extends('adminlte::page')


@section('title','Ajouter utilisateur')



@section('content_header')

<h1>Ajouter un utilisateur</h1>

@stop



@section('content')


<div class="card">


<div class="card-body">


<form method="POST"
action="{{ route('users.store') }}">


@csrf



<div class="form-group">

<label>Nom</label>

<input type="text"
name="name"
class="form-control"
value="{{old('name')}}">

</div>



<div class="form-group">

<label>Email</label>

<input type="email"
name="email"
class="form-control"
value="{{old('email')}}">

</div>




<div class="form-group">

<label>Mot de passe</label>


<input type="password"
name="password"
class="form-control">


</div>




<div class="form-group">

<label>Rôle</label>


<select name="role"
class="form-control">


<option value="admin">

Responsable financier

</option>



<option value="user">

Agent back office

</option>


</select>


</div>



<button class="btn btn-success">

Enregistrer

</button>


<a href="{{route('users.index')}}"
class="btn btn-secondary">

Annuler

</a>



</form>



</div>

</div>



@stop