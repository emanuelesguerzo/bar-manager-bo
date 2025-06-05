@extends('layouts.app')

@section('title', 'Il nostro menù')

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

        {{-- Ricerca --}}
        <form method="GET" action="{{ route('admin.sellables.index') }}" class="mb-4">
            <div class="row g-2 align-items-end">

                {{-- Campo ricerca --}}
                <div class="col-md-5">
                    <label for="search" class="form-label">Cerca per nome</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Es: Cappuccino...">
                </div>

                {{-- Filtro categoria --}}
                <div class="col-md-5">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Tutte le categorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Bottoni Cerca e Reset --}}
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-50" type="submit">Cerca</button>
                    <a href="{{ route('admin.sellables.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                </div>
            </div>
        </form>

        {{-- Aggiungi Nuovo --}}
        <div>
            <a class="btn btn-primary mb-3" href="{{ route('admin.sellables.create') }}">+ Aggiungi un nuovo articolo</a>
        </div>

        {{-- Grid --}}
        <div class="row">
            @foreach ($sellables as $sellable)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
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
                            <li class="list-group-item">{{ $sellable->category->name }}</li>
                            <li class="list-group-item"><a href="{{ route('admin.sellables.show', $sellable->slug) }}"
                                    class="">Dettagli</a></li>
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
                <x-modal.delete-sellable :sellable="$sellable" />
            @endforeach
            @if ($sellables->isEmpty())
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto corrisponde alla ricerca o alla categoria selezionata.
                </div>
            @endif
        </div>
        {{ $sellables->withQueryString()->links() }}
    </div>

@endsection
