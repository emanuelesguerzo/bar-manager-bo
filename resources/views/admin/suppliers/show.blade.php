@extends('layouts.app')

@section('title', "Prodotti del fornitore $supplier->name")

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Grid --}}
        <div class="row">
            @forelse ($supplier->products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 d-flex flex-column justify-content-between">
                        @if ($product->image)
                            <div class="card-header">
                                <img class="img-fluid w-100 rounded" style="height: 180px; object-fit: cover;"
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="Immagine del prodotto {{ $product->name }}">
                            </div>
                        @endif

                        <div class="card-body py-2">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            @if ($product->brand)
                                <small class="text-muted">{{ $product->brand }}</small>
                            @endif
                        </div>

                        <ul class="list-group list-group-flush mt-auto">
                            <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }}€
                                @if ($product->unit_size_ml)
                                    <span class="text-muted">/ {{ $product->unit_size_ml }} ml</span>
                                @endif
                                @if ($product->unit_size_g)
                                    <span class="text-muted">/ {{ $product->unit_size_g }} g</span>
                                @endif
                            </li>
                            <li class="list-group-item"><strong>In magazzino:</strong> {{ $product->units_in_stock }} unità
                            </li>
                            {{-- Stock e unità se presenti --}}
                            @if ($product->stock_ml)
                                <li class="list-group-item"><strong>Stock:</strong> {{ $product->stock_ml }} ml</li>
                            @endif

                            @if ($product->stock_g)
                                <li class="list-group-item"><strong>Stock:</strong> {{ $product->stock_g }} g</li>
                            @endif

                            <li class="list-group-item">
                                <strong>Fornitore:</strong>
                                {{ $product->supplier?->name ?? '—' }}
                            </li>
                            <li class="list-group-item text-center">
                                <a href="{{ route('admin.products.show', $product->slug) }}"
                                    class="btn btn-outline-primary btn-sm w-100">Dettagli</a>
                            </li>
                        </ul>

                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-outline-success"
                                href="{{ route('admin.products.edit', $product) }}">Modifica</a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $product->id }}">
                                Elimina
                            </button>
                        </div>
                    </div>
                </div>
                <x-modal.delete-product :product="$product" />
            @empty
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto associato a questo fornitore.
                </div>
            @endforelse
        </div>
    </div>
@endsection
