@extends('layouts.app')

@section('title', 'Aggiungi una nuova categoria')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Form Categoria --}}
        <form class="border rounded p-3" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            {{-- Nome Categoria --}}
            <div class="mb-3">
                <label class="form-label label-required" for="name">Nome della categoria</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                    maxlength="255" value="{{ old('name') }}" placeholder="Es: Pizzeria" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Descrizione Categoria --}}
            <div class="mb-4">
                <label class="form-label" for="description">Descrizione della categoria</label>
                <textarea class="form-control" type="text" name="description" id="description" rows="2" placeholder="Es: Prodotti tipici di una pizzeria...">{{ old('description') }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>
        
    </div>
@endsection
