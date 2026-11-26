@extends('adminlte::page')

@section('title','Gestion utilisateurs')


@section('content_header')

<h1>Gestion des utilisateurs</h1>

@stop



@section('content')


@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>

@endif



<a href="{{ route('users.create') }}" 
class="btn btn-primary mb-3">

Ajouter un utilisateur

</a>



<table class="table table-bordered table-striped">


<thead>

<tr>

<th>Nom</th>

<th>Email</th>

<th>Rôle</th>

<th>Actions</th>

</tr>

</thead>



<tbody>


@foreach($users as $user)


<tr>


<td>
{{ $user->name }}
</td>


<td>
{{ $user->email }}
</td>


<td>

@if($user->role == 'admin')

<span class="badge badge-success">
Responsable financier
</span>


@else


<span class="badge badge-info">
Agent back office
</span>


@endif


</td>



<td>

<a href="{{route('users.show',$user->id)}}"
class="btn btn-info btn-sm">
Voir
</a>


<a href="{{route('users.edit',$user->id)}}"
class="btn btn-warning btn-sm">
Modifier
</a>



<form action="{{route('users.destroy',$user->id)}}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Supprimer
</button>

</form>


</td>

</tr>


@endforeach


</tbody>


</table>


<a href="{{ route('parametres.index') }}"
   class="btn btn-secondary">

    <i class="fas fa-arrow-left"></i>
    Retour

</a>
@stop