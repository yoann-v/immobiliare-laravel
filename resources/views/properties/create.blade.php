@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Form en GET</h2>
        @if (request('name'))
        Bonjour {{ request('name') }}
        @endif

        <form action="">
            <input type="text" name="name">

            <button class="btn btn-primary">Envoyer</button>
        </form>

        <h2>Form en POST</h2>

        <form action="" method="post">
            @csrf
            <input type="text" name="title">

            <button class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection