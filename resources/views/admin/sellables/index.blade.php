@extends('layouts.app')

@section('title', 'Il nostro menù')

@section('content')
    <div class="container mt-3">

        {{-- Alert Successo --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        {{-- Titolo Principale --}}
        <h1 class="my-4">@yield('title')</h1>
        
        {{-- Aggiungi Nuovo --}}
        <div class="d-flex justify-content-end my-3">
            <a class="btn btn-primary" href="{{ route('admin.sellables.create') }}"><i class="fa-solid fa-plus me-2"></i>Nuovo</a>
        </div>

        {{-- Ricerca --}}
        <form method="GET" action="{{ route('admin.sellables.index') }}" class="border rounded p-2 mb-4 " >
            <div class="row g-2 align-items-end">

                {{-- Campo ricerca --}}
                <div class="col-md-4">
                    <label for="search" class="form-label">Cerca per nome</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Es: Cappuccino...">
                </div>

                {{-- Filtro categoria --}}
                <div class="col-md-4">
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
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Cerca</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.sellables.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>


        {{-- Grid --}}
        <div class="row">
            @foreach ($sellables as $sellable)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card h-100 d-flex flex-column justify-content-between">
                        
                        {{-- Immagine --}}
                        @if ($sellable->image)
                            <div class="card-header">
                                <img class="img-fluid w-100 rounded"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    src="{{ asset('storage/' . $sellable->image) }}"
                                    alt="Immagine della pagina {{ $sellable->name }}">
                            </div>
                        @endif

                        {{-- Nome e Descrizione --}}
                        <div class="card-body py-2">
                            <h5 class="card-title">{{ $sellable['name'] }}</h5>
                            <p class="card-text">{{ $sellable['description'] }}</p>
                        </div>

                        {{-- Lista --}}
                        <ul class="list-group list-group-flush mt-auto">

                            {{-- Prezzo --}}
                            <li class="list-group-item">Prezzo: {{ $sellable['price'] }} €</li>

                            {{-- Categoria --}}
                            @if ($sellable->category)
                                <li class="list-group-item">{{ $sellable->category->name }}</li>
                            @endif
                            {{-- Ingredienti --}}
                            <li class="list-group-item">Ingredienti: {{ $sellable->products->count() }}</li>
                            
                            {{-- Dettagli --}}
                            <li class="list-group-item text-center">
                                <a href="{{ route('admin.sellables.show', $sellable->slug) }}"
                                    class="btn btn-outline-primary btn-sm w-100">Dettagli</a>
                            </li>

                        </ul>
                        
                        {{-- Bottoni Modifica e Elimina --}}
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

                {{-- Modale Elimina --}}
                <x-modal.delete-sellable :sellable="$sellable" />

            @endforeach

            {{-- Nessuno Prodotto --}}
            @if ($sellables->isEmpty())
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto corrisponde alla ricerca o alla categoria selezionata.
                </div>
            @endif
            
        </div>

        {{-- Navigazione --}}
        {{ $sellables->withQueryString()->links() }}

    </div>

@endsection
