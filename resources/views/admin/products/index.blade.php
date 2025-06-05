@extends('layouts.app')

@section('title', 'I nostri prodotti')

@section('content')
    <div class="container mt-3">
        {{-- Alert Successo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Titolo Principale --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
            <div class="row g-2 align-items-end">
                {{-- Campo ricerca --}}
                <div class="col-md-5">
                    <label for="search" class="form-label">Cerca per nome o marca</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Es: Prosecco...">
                </div>

                {{-- Bottoni Cerca e Reset --}}
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-50" type="submit">Cerca</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                </div>
            </div>
        </form>

        {{-- Aggiungi Nuovo --}}
        <div>
            <a class="btn btn-primary mb-3" href="{{ route('admin.products.create') }}">+ Aggiungi un nuovo prodotto</a>
        </div>

        {{-- Grid --}}
        <div class="row">
            @foreach ($products as $product)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
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
            @endforeach
            @if ($products->isEmpty())
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto corrisponde alla ricerca.
                </div>
            @endif
        </div>

        {{-- Paginazione --}}
        {{ $products->withQueryString()->links() }}
    </div>
@endsection
