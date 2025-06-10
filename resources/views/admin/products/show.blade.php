@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Torna indietro --}}
        <div class="mt-4">
            <a href="{{ route('admin.products.index') }}" class="btn back-btn">← Torna indietro</a>
        </div>

        {{-- Card --}}
        <div class="card h-100 d-flex flex-column mt-3">

            {{-- Immagine --}}
            @if ($product->image)
                <div class="card-header text-center">
                    <img class="img-fluid rounded" style="max-width: 100%; width: 400px; object-fit: cover;"
                        src="{{ asset('storage/' . $product->image) }}" alt="Immagine della pagina {{ $product->name }}">
                </div>
            @endif

            {{-- Nome Prodotto --}}
            <div class="card-body">
                <h5 class="card-title mb-0">{{ $product->name }}</h5>
            </div>

            {{-- Marca, Fornitore, Prezzo, Dimensione Prodotto, Quantita' in Stock, Stock totale in ml o g --}}
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Marca: <strong class="text-muted">{{ $product->brand }}</strong></li>
                <li class="list-group-item">Fornitore: <strong class="text-muted">{{ $product->supplier->name }}</strong>
                </li>
                <li class="list-group-item">Prezzo: <strong class="text-muted">{{ $product->price }} €</strong>
                    @if ($product->unit_size_ml)
                        <span>/ {{ $product->unit_size_ml }} ml</span>
                    @endif
                    @if ($product->unit_size_g)
                        <span>/ {{ $product->unit_size_g }} g</span>
                    @endif
                </li>
                <li class="list-group-item">In magazzino: <strong class="text-muted">{{ $product->units_in_stock }}
                    </strong>unità</li>
                @if ($product->stock_ml)
                    <li class="list-group-item">Stock: <strong class="text-muted">{{ $product->stock_ml }} ml</strong></li>
                @endif
                @if ($product->stock_g)
                    <li class="list-group-item">Stock: <strong class="text-muted">{{ $product->stock_g }} g</strong></li>
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
                                                class="form-control flex-grow-1" placeholder="Unità">
                                            <button class="btn add-btn w-btn">+ Aggiungi</button>
                                        </div>
                                    </form>

                                    {{-- Scarica stock --}}
                                    <form method="POST" action="{{ route('admin.products.removeStock', $product) }}">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="remove_units" min="1"
                                                max="{{ $product->units_in_stock }}" class="form-control flex-grow-1"
                                                placeholder="Unità">
                                            <button class="btn confirm-delete-btn w-btn">- Scarica</button>
                                        </div>
                                    </form>

                                    {{-- Scarico completo stock --}}
                                    <form method="POST" action="{{ route('admin.products.clearStock', $product) }}">
                                        @csrf
                                        <button type="button" class="btn confirm-delete-btn w-100 mt-2"
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

            {{-- Bottoni Modifica e Elimina --}}
            <div class="card-footer d-flex justify-content-between">
                <a class="btn modify-btn" href="{{ route('admin.products.edit', $product) }}"><i class="fa-solid fa-pencil"></i></a>
                <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                    data-bs-target="#destroyModal-{{ $product->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>

        {{-- Navigazione tra prodotti --}}
        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('admin.products.show', $previous->slug) }}" class="btn back-btn">
                ← {{ $previous->name }}
            </a>
            <a href="{{ route('admin.products.show', $next->slug) }}" class="btn forward-btn">
                {{ $next->name }} →
            </a>
        </div>
    </div>

    {{-- Modale --}}
    <x-modal.delete-product :product="$product" />

@endsection
