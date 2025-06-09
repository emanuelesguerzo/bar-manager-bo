@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="mt-4">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">← Torna indietro</a>
        </div>
        <div class="card h-100 d-flex flex-column mt-1">
            @if ($product->image)
                <div class="card-header text-center">
                    <img class="img-fluid rounded" style="max-width: 100%; width: 400px; object-fit: cover;"
                        src="{{ asset('storage/' . $product->image) }}" alt="Immagine della pagina {{ $product->name }}">
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text">{{ $product['brand'] }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Prezzo:</strong> {{ $product['price'] }} €</li>
                <li class="list-group-item"><strong>Fornitore:</strong> {{ $product->supplier->name }}</li>
                <li class="list-group-item"><strong>In Magazzino:</strong> {{ $product['units_in_stock'] }}</li>
                @if ($product->stock_ml)
                    <li class="list-group-item"><strong>Stock:</strong> {{ $product->stock_ml }} ml</li>
                @endif

                @if ($product->stock_g)
                    <li class="list-group-item"><strong>Stock:</strong> {{ $product->stock_g }} g</li>
                @endif

                {{-- Carico e scarico merce magazzino --}}
                <li class="list-group-item p-0">
                    <div class="accordion" id="accordion-{{ $product->id }}">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="heading-{{ $product->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $product->id }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $product->id }}">
                                    Gestione magazzino
                                </button>
                            </h2>
                            <div id="collapse-{{ $product->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ $product->id }}"
                                data-bs-parent="#accordion-{{ $product->id }}">
                                <div class="accordion-body">
                                    {{-- Aggiungi stock --}}
                                    <form method="POST" action="{{ route('admin.products.addStock', $product) }}"
                                        class="mb-2">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="new_units" min="1"
                                                class="form-control flex-grow-1" placeholder="Aggiungi unità">
                                            <button class="btn btn-success w-btn">+ Aggiungi</button>
                                        </div>
                                    </form>

                                    {{-- Scarica stock --}}
                                    <form method="POST" action="{{ route('admin.products.removeStock', $product) }}">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="remove_units" min="1"
                                                max="{{ $product->units_in_stock }}" class="form-control flex-grow-1"
                                                placeholder="Scarica unità">
                                            <button class="btn btn-danger w-btn">- Scarica</button>
                                        </div>
                                    </form>

                                    {{-- Scarico Completo --}}
                                    <form method="POST" action="{{ route('admin.products.clearStock', $product) }}">
                                        @csrf
                                        <button type="button" class="btn btn-outline-warning w-100 mt-2"
                                            data-bs-toggle="modal" data-bs-target="#clearStockModal-{{ $product->id }}">
                                            <i class="fa-solid fa-arrows-rotate me-2"></i> Scarico completo
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
            <div class="card-footer d-flex justify-content-between">
                <a class="btn btn-outline-success" href="{{ route('admin.products.edit', $product) }}">Modifica</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#destroyModal-{{ $product->id }}">
                    Elimina
                </button>
            </div>
        </div>
        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('admin.products.show', $previous->slug) }}" class="btn btn-outline-secondary">
                ← {{ $previous->name }}
            </a>
            <a href="{{ route('admin.products.show', $next->slug) }}" class="btn btn-outline-secondary">
                {{ $next->name }} →
            </a>
        </div>
    </div>
    <x-modal.delete-product :product="$product" />
@endsection
