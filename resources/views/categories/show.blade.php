@extends('adminlte::page')


@section('title','Détail catégorie')


@section('content_header')

<h1>
    <i class="fas fa-tag"></i>
    Détail catégorie
</h1>

@stop



@section('content')


<div class="card">


<div class="card-body">


<p>

<strong>ID :</strong>

{{ $category->id }}

</p>



<p>

<strong>Nom :</strong>

{{ $category->name }}

</p>



<p>

<strong>Description :</strong>

{{ $category->description }}

</p>




<a href="{{ route('categories.index') }}"
   class="btn btn-primary">

Retour

</a>


<a href="{{ route('categories.edit',$category->id) }}"
   class="btn btn-warning">

Modifier

</a>



</div>


</div>



@stop