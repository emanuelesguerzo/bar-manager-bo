@extends('layouts.app')

@section('title', 'Modifica prodotto del menù')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.sellables.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Form --}}
        <form class="border rounded p-3" action="{{ route('admin.sellables.update', $sellable) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nome Prodotto --}}
            <div class="mb-3">
                <label class="form-label label-required" for="name">Nome del Prodotto</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                    maxlength="255" value="{{ $sellable->name }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Prezzo Prodotto --}}
            <div class="mb-3">
                <label class="form-label label-required" for="price">Prezzo del Prodotto</label>
                <input class="form-control @error('price') is-invalid @enderror" type="number" name="price" id="price" step="0.01" min="0"
                    max="9999.99" value="{{ $sellable->price }}" required>
                @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Categoria del Prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="category_id">Categoria Prodotto</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">— Seleziona categoria —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $sellable->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Visibilità del prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="form-check">Visibilità prodotto</label>
                <div class="form-check">
                    <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input"
                        {{ $sellable->is_visible ? 'checked' : '' }}>
                    <label class="mb-2" for="is_visible" class="form-check-label">Visibile nel menù</label>
                </div>
            </div>

            {{-- Immagine Prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="image">Immagine del Prodotto</label>
                <input class="form-control" type="file" name="image" id="image">
                @if ($sellable->image)
                    <div class="mb-3">
                        <p>Immagine attuale:</p>
                        <img src="{{ asset('storage/' . $sellable->image) }}" alt="{{ $sellable->name }}"
                            class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="delete_image" id="delete_image" class="form-check-input">
                        <label for="delete_image" class="form-check-label">Rimuovi immagine</label>
                    </div>
                @endif
            </div>

            {{-- Descrizione Prodotto --}}
            <div class="mb-4">
                <label class="form-label" for="description">Descrizione del Prodotto</label>
                <textarea class="form-control" name="description" id="description" rows="2" placeholder="Es: Bevanda a base di gelato">{{ $sellable->description }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>

    </div>
@endsection
