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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/annonce/creer" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">

                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" value="{{ old('description') }}"></textarea>
            </div>
            <div>
                <label for="price">Prix</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
            </div>
            <div class="form-check">
                <input type="checkbox" name="sold" id="sold" class="form-check-input" {{ old('sold') ? 'checked' : '' }}>
                <label for="sold">Vendu ?</label>
            </div>

            <button class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection