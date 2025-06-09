@extends('layouts.app')

@section('title', 'Modifica un prodotto')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        <form class="border rounded p-3" method="POST" action="{{ route('admin.products.update', $product) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nome Prodotto --}}
            <div class="mb-3">
                <label for="name" class="form-label label-required">Nome prodotto</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            {{-- Brand Prodotto --}}
            <div class="mb-3">
                <label for="brand" class="form-label">Marca</label>
                <input type="text" name="brand" id="brand" class="form-control"
                    value="{{ old('brand', $product->brand) }}" placeholder="Es: Kellerei Bozen">
            </div>

            {{-- Prezzo Prodotto --}}
            <div class="mb-3">
                <label for="price" class="form-label label-required">Prezzo (€)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            {{-- Quantità + unità di misura --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="stock_quantity" class="form-label">Quantità per unità</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0"
                        value="{{ old('stock_quantity') ?? ($product->unit_size_ml ?? $product->unit_size_g) }}">
                </div>

                <div class="col-md-6">
                    <label for="stock_unit" class="form-label">Unità</label>
                    <select name="stock_unit" id="stock_unit" class="form-select">
                        <option value="">— Seleziona unità —</option>
                        <option value="ml"
                            {{ old('stock_unit', $product->unit_size_ml !== null ? 'ml' : '') == 'ml' ? 'selected' : '' }}>
                            Millilitri (ml)</option>
                        <option value="g"
                            {{ old('stock_unit', $product->unit_size_g !== null ? 'g' : '') == 'g' ? 'selected' : '' }}>
                            Grammi (g)</option>
                    </select>
                </div>
            </div>

            {{-- Fornitore --}}
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Fornitore</label>
                <select name="supplier_id" id="supplier_id" class="form-select">
                    <option value="">— Seleziona fornitore —</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Immagine --}}
            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" name="image" id="image" class="form-control mb-2">
                @if ($product->image)
                    <div class="mb-3">
                        <p>Immagine attuale:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <div class="form-check my-2">
                        <input type="checkbox" name="delete_image" id="delete_image" class="form-check-input">
                        <label for="delete_image" class="form-check-label">Rimuovi immagine</label>
                    </div>
                @endif
            </div>

            {{-- Soglia alert magazzino --}}
            <div class="mb-4">
                <label for="stock_alert_threshold" class="form-label label-required">Soglia alert magazzino</label>
                <input type="number" name="stock_alert_threshold" id="stock_alert_threshold" class="form-control"
                    value="{{ old('stock_alert_threshold', $product->stock_alert_threshold) }}" min="1" required>
                <div class="form-text">Invia un alert nella dashboard quando le unità in magazzino scendono a questo
                    valore.</div>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>

    </div>
@endsection
