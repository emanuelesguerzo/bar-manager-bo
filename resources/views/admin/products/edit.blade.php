@extends('layouts.app')

@section('title', 'Modifica un prodotto')

@section('content')
    <div class="container mt-4">
        <div class="mt-4">
            <a class=" btn btn-primary" href="{{ route('admin.products.index') }}">Torna ai prodotti</a>
        </div>
        <h1 class="mt-3">@yield('title')</h1>

        <form method="POST" action="{{ route('admin.products.update', $product) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-control d-flex flex-column mt-4 mb-2">

                {{-- Nome Prodotto --}}
                <label for="name" class="form-label">Nome prodotto</label>
                <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $product->name) }}" required>

                {{-- Brand --}}
                <label for="brand" class="form-label">Marca</label>
                <input type="text" name="brand" id="brand" class="form-control"
                        value="{{ old('brand', $product->brand) }}">

                {{-- Prezzo --}}
                <label for="price" class="form-label">Prezzo (€)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control"
                        value="{{ old('price', $product->price) }}" required>
            
                {{-- Unità disponibili --}}
                <label for="units_in_stock" class="form-label">Unità in magazzino</label>
                <input type="number" name="units_in_stock" id="units_in_stock" class="form-control"
                        value="{{ old('units_in_stock', $product->units_in_stock) }}" required>

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
                                {{ old('stock_unit') == 'ml' || $product->unit_size_ml ? 'selected' : '' }}>
                                Millilitri (ml)</option>
                            <option value="g"
                                {{ old('stock_unit') == 'g' || $product->unit_size_g ? 'selected' : '' }}>
                                Grammi (g)</option>
                        </select>
                    </div>
                </div>

                {{-- Fornitore --}}
                <label for="supplier_id" class="form-label">Fornitore</label>
                <select name="supplier_id" id="supplier_id" class="form-select">
                    <option value="">Nessuno</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Immagine --}}
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

            {{-- Submit --}}
            <button type="submit" class="btn btn-success">Salva</button>
        </form>
    </div>
@endsection
