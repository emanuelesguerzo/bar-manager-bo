@extends('layouts.app')

@section('title', "Prodotti della categoria $category->name")

@section('content')
    <div class="container mt-3">


        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="mt-4 mb-3">@yield('title')</h1>

        {{-- Descrizione Categoria --}}
        <p class="text-muted mb-4">{{ $category->description }}</p>

        {{-- Grid --}}
        <div class="row">
            @forelse ($category->sellables as $sellable)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 d-flex flex-column justify-content-between">
                        @if ($sellable->image)
                            <div class="card-header">
                                <img class="img-fluid w-100 rounded"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    src="{{ asset('storage/' . $sellable->image) }}"
                                    alt="Immagine della pagina {{ $sellable->name }}">
                            </div>
                        @endif
                        <div class="card-body py-2">
                            <h5 class="card-title">{{ $sellable['name'] }}</h5>
                            <p class="card-text">{{ $sellable['description'] }}</p>
                        </div>
                        <ul class="list-group list-group-flush mt-auto">
                            <li class="list-group-item">Prezzo: {{ $sellable['price'] }} €</li>
                            @if ($sellable->category)
                                <li class="list-group-item">{{ $sellable->category->name }}</li>
                            @endif
                            <li class="list-group-item text-center">
                                <a href="{{ route('admin.sellables.show', $sellable->slug) }}"
                                    class="btn btn-outline-primary btn-sm w-100">Dettagli</a>
                            </li>
                        </ul>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-outline-success"
                                href="{{ route('admin.sellables.edit', $sellable) }}">Modifica</a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $sellable->id }}">
                                Elimina
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto associato a questa categoria.
                </div>
            @endforelse
        </div>
    </div>
@endsection
