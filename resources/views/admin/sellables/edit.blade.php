@extends('layouts.app')

@section('title', 'Modifica Prodotto del Menù')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a class=" btn btn-primary" href="{{ route('admin.sellables.index') }}">Torna al menù</a>
        </div>

        <h1 class="mt-3">@yield('title')</h1>
        <form action="{{ route('admin.sellables.update', $sellable) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-control d-flex flex-column mt-4 mb-2">

                {{-- Nome Prodotto --}}
                <label class="mb-2 fs-5" for="name">Nome del Prodotto</label>
                <input class="mb-3" type="text" name="name" id="name" maxlength="255"
                    value="{{ $sellable->name }}" required>

                {{-- Descrizione Prodotto --}}
                <label class="mb-2 fs-5" for="description">Descrizione del Prodotto</label>
                <textarea class="mb-3" type="text" name="description" id="description" rows="2">{{ $sellable->description }}</textarea>

                {{-- Prezzo Prodotto --}}
                <label class="mb-2 fs-5" for="price">Prezzo del Prodotto</label>
                <input class="mb-3" type="number" name="price" id="price" step="0.01" min="0"
                    max="9999.99" value="{{ $sellable->price }}" required>

                {{-- Immagine Prodotto --}}
                <label class="mb-2 fs-5" for="image">Immagine del Prodotto</label>
                <input class="mb-3" type="file" name="image" id="image">
                @if ($sellable->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $sellable->image) }}" alt="{{ $sellable->name }}" class="img-fluid"
                            style="max-height: 200px;">
                    </div>
                @endif

                {{-- Visibilità del prodotto --}}
                <label class="mb-2 fs-5" for="form-check">Visibilità prodotto</label>
                <div class="form-check">
                    <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input"
                        {{ $sellable->is_visible ? 'checked' : '' }}>
                    <label class="mb-2" for="is_visible" class="form-check-label">Visibile nel menù</label>
                </div>

                {{-- Categoria del Prodotto --}}
                <label class="mb-2 fs-5" for="category_id">Categoria Prodotto</label>
                <select class="mb-3" name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $sellable->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>

            </div>

            {{-- Salva Progetto --}}
            <input class="btn btn-primary" type="submit" value="Salva">

        </form>
    </div>
@endsection
