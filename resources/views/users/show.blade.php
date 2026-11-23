@extends('adminlte::page')


@section('title','Détail utilisateur')



@section('content_header')

<h1>Détail utilisateur</h1>

@stop



@section('content')


<div class="card">

<div class="card-body">


<p>
<strong>Nom :</strong>
{{ $user->name }}
</p>


<p>
<strong>Email :</strong>
{{ $user->email }}
</p>



<p>

<strong>Rôle :</strong>


@if($user->role=='admin')

Responsable financier

@else

Agent back office

@endif


</p>



<a href="{{route('users.index')}}"
class="btn btn-primary">

Retour

</a>


</div>

</div>



@stop