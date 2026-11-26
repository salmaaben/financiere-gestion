@extends('adminlte::page')


@section('title','Modifier catégorie')


@section('content_header')

<h1>
    <i class="fas fa-edit"></i>
    Modifier une catégorie
</h1>

@stop



@section('content')


<div class="card">


<div class="card-body">


<form method="POST"
      action="{{ route('categories.update',$category->id) }}">


@csrf

@method('PUT')



<div class="form-group">

<label>
Nom de la catégorie
</label>


<input type="text"
       name="name"
       class="form-control"
       value="{{ $category->name }}">


</div>




<div class="form-group">

<label>
Description
</label>


<textarea name="description"
          class="form-control"
          rows="4">{{ $category->description }}</textarea>


</div>




<button class="btn btn-success">

Modifier

</button>



<a href="{{ route('categories.index') }}"
   class="btn btn-secondary">

Retour

</a>



</form>


</div>


</div>


@stop