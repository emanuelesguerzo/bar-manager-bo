@extends('layouts.app')

@section('title', 'Aggiungi un nuovo prodotto al menù')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.sellables.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Form --}}
        <form class="border rounded p-3" action="{{ route('admin.sellables.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            {{-- Nome Prodotto --}}
            <div class="mb-3">
                <label class="form-label label-required" for="name">Nome del prodotto</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                    maxlength="255" value="{{ old('name') }}" placeholder="Es: Frappè" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Prezzo Prodotto --}}
            <div class="mb-3">
                <label class="form-label label-required" for="price">Prezzo (€)</label>
                <input class="form-control" type="number" name="price" id="price" step="0.01" min="0"
                    max="9999.99" value="{{ old('price') }}" placeholder="Es: 3.00" required>
            </div>

            {{-- Ingredienti Prodotto --}}
            <div class="mb-4">
                <label class="form-label">Ingredienti del prodotto</label>

                {{-- Wrapper dinamico --}}
                <div id="ingredients-wrapper"></div>

                {{-- Bottone aggiunta ingrediente --}}
                <button type="button" class="btn btn-outline-primary mt-2" id="add-ingredient">
                    + Aggiungi ingrediente
                </button>
            </div>

            {{-- Categoria del Prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="category_id">Categoria prodotto</label>
                <select class="form-select" name="category_id" id="category_id">
                    <option value="">— Seleziona categoria —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Visibilità del prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="form-check">Visibilità prodotto</label>
                <div class="form-check">
                    <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input"
                        {{ old('is_visible', true) ? 'checked' : '' }}>
                    <label for="is_visible" class="form-check-label">Visibile nel menù</label>
                </div>
            </div>

            {{-- Immagine Prodotto --}}
            <div class="mb-3">
                <label class="form-label" for="image">Immagine del prodotto</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>

            {{-- Descrizione Prodotto --}}
            <div class="mb-4">
                <label class="form-label" for="description">Descrizione del prodotto</label>
                <textarea class="form-control" name="description" id="description" rows="2"
                    placeholder="Es: Bevanda a base di gelato">{{ old('description') }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>
        
        {{-- Template Ingredienti --}}
        <template id="ingredient-template">
            <div class="ingredient-group border rounded p-3 mb-3">
                <div class="row align-items-end">

                    {{-- Selezione Ingrediente --}}
                    <div class="col-md-6">
                        <label class="form-label">Ingrediente</label>
                        <select name="product_id[]" class="form-select">
                            <option value="">— Seleziona prodotto —</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quantità Ingrediente --}}
                    <div class="col-md-3">
                        <label class="form-label">Quantità</label>
                        <input type="number" name="quantity[]" class="form-control" min="1" value="1">
                    </div>

                    {{-- Unità Ingrediente --}}
                    <div class="col-md-2">
                        <label class="form-label">Unità</label>
                        <select name="unit[]" class="form-select">
                            <option value="ml">ml</option>
                            <option value="g">g</option>
                            <option value="pz">pz</option>
                        </select>
                    </div>

                    {{-- Rimuovi Ingrediente --}}
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-danger remove-ingredient">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                </div>
            </div>
        </template>
    </div>
@endsection
