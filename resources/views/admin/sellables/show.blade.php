@extends('layouts.app')

@section('title', $sellable->name)

@section('content')
    <div class="container">

        {{-- Alert Successo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Torna indietro --}}
        <div class="mt-4">
            <a href="{{ route('admin.sellables.index') }}" class="btn btn-secondary mb-3">← Torna indietro</a>
        </div>

        {{-- Card --}}
        <div class="card h-100 d-flex flex-column mt-1">

            {{-- Immagine --}}
            @if ($sellable->image)
                <div class="card-header text-center">
                    <img class="img-fluid rounded" style="max-width: 100%; width: 400px; object-fit: cover;"
                        src="{{ asset('storage/' . $sellable->image) }}" alt="Immagine della pagina {{ $sellable->name }}">
                </div>
            @endif

            {{-- Nome e Descrizione --}}
            <div class="card-body">
                <h5 class="card-title">{{ $sellable['name'] }}</h5>
                <p class="card-text">{{ $sellable['description'] }}</p>
            </div>

            {{-- Lista --}}
            <ul class="list-group list-group-flush">

                {{-- Prezzo --}}
                <li class="list-group-item">Prezzo: {{ $sellable->price }} €</li>

                {{-- Categoria --}}
                @if ($sellable->category)
                    <li class="list-group-item">Categoria: {{ $sellable->category->name }}</li>
                @endif

                {{-- Ingredienti --}}
                <li class="list-group-item">
                    <strong>Ingredienti:</strong>
                    @if ($sellable->products->isNotEmpty())
                        <ul class="mt-2 ps-3">
                            @foreach ($sellable->products as $product)
                                <li>
                                    {{ $product->name }} – {{ $product->pivot->quantity }} {{ $product->pivot->unit }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-0">Nessun ingrediente specificato.</p>
                    @endif
                </li>

            </ul>

            {{-- Bottoni Modifica e Elimina --}}
            <div class="card-footer d-flex justify-content-between">
                <a class="btn btn-outline-success" href="{{ route('admin.sellables.edit', $sellable) }}">Modifica</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#destroyModal-{{ $sellable->id }}">
                    Elimina
                </button>
            </div>

        </div>

        {{-- Navigazione --}}
        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('admin.sellables.show', $previous->slug) }}" class="btn btn-outline-secondary">
                ← {{ $previous->name }}
            </a>
            <a href="{{ route('admin.sellables.show', $next->slug) }}" class="btn btn-outline-secondary">
                {{ $next->name }} →
            </a>
        </div>
    </div>

    {{-- Modale Elimina --}}
    <x-modal.delete-sellable :sellable="$sellable" />
    
@endsection
