@extends('layouts.app')

@section('title', 'Aggiungi un nuovo prodotto')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Form --}}
        <form class="border rounded p-3" method="POST" action="{{ route('admin.products.store') }}"
            enctype="multipart/form-data">
            @csrf

            {{-- Nome Prodotto --}}
            <div class="mb-3">
                <label for="name" class="form-label label-required">Nome prodotto</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Es: Taber" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Brand Prodotto --}}
            <div class="mb-3">
                <label for="brand" class="form-label">Marca</label>
                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}" placeholder="Es: Kellerei Bozen">
            </div>

            {{-- Prezzo Prodotto --}}
            <div class="mb-3">
                <label for="price" class="form-label label-required">Prezzo (€)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control"
                    value="{{ old('price') }}" placeholder="Es: 45.00" required>
            </div>

            {{-- Unità disponibili --}}
            <div class="mb-3">
                <label for="units_in_stock" class="form-label label-required">Unità in magazzino</label>
                <input type="number" name="units_in_stock" id="units_in_stock" class="form-control"
                    value="{{ old('units_in_stock') }}" placeholder="Es: 6" required>
            </div>

            {{-- Quantità + unità di misura --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="stock_quantity" class="form-label">Quantità per unità</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0"
                        value="{{ old('stock_quantity') }}" placeholder="Es: 750">
                </div>

                <div class="col-md-6">
                    <label for="stock_unit" class="form-label">Unità</label>
                    <select name="stock_unit" id="stock_unit" class="form-select">
                        <option value="">— Seleziona unità —</option>
                        <option value="ml" {{ old('stock_unit') == 'ml' ? 'selected' : '' }}>Millilitri (ml)</option>
                        <option value="g" {{ old('stock_unit') == 'g' ? 'selected' : '' }}>Grammi (g)</option>
                    </select>
                </div>
            </div>

            {{-- Fornitore --}}
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Fornitore</label>
                <select name="supplier_id" id="supplier_id" class="form-select">
                    <option value="">— Seleziona fornitore —</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Immagine --}}
            <div class="mb-4">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>

    </div>
@endsection
