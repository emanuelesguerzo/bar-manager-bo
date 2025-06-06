@extends('layouts.app')

@section('title', 'Aggiungi un nuovo prodotto')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">@yield('title')</h1>

    <form class="form-control" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nome prodotto</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        {{-- Brand --}}
        <div class="mb-3">
            <label for="brand" class="form-label">Marca</label>
            <input type="text" name="brand" id="brand" class="form-control">
        </div>

        {{-- Prezzo --}}
        <div class="mb-3">
            <label for="price" class="form-label">Prezzo (€)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>

        {{-- Unità disponibili --}}
        <div class="mb-3">
            <label for="units_in_stock" class="form-label">Unità in magazzino</label>
            <input type="number" name="units_in_stock" id="units_in_stock" class="form-control" required>
        </div>

        {{-- Quantità + unità di misura --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="stock_quantity" class="form-label">Quantità per unità</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" min="0">
            </div>

            <div class="col-md-6">
                <label for="stock_unit" class="form-label">Unità</label>
                <select name="stock_unit" id="stock_unit" class="form-select">
                    <option value="">— Seleziona unità —</option>
                    <option value="ml">Millilitri (ml)</option>
                    <option value="g">Grammi (g)</option>
                </select>
            </div>
        </div>

        {{-- Fornitore --}}
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Fornitore</label>
            <select name="supplier_id" id="supplier_id" class="form-select">
                <option value="">Nessuno</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Immagine --}}
        <div class="mb-3">
            <label for="image" class="form-label">Immagine</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-success">Salva</button>
    </form>
</div>
@endsection