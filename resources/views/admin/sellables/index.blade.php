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
            <a class="btn btn-new" href="{{ route('admin.sellables.create') }}"><i
                    class="fa-solid fa-plus me-2"></i>Nuovo</a>
        </div>

        {{-- Ricerca --}}
        <form method="GET" action="{{ route('admin.sellables.index') }}" class="search-box rounded p-2 mb-3 ">
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
                    <button class="btn search-btn w-100" type="submit">Cerca</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.sellables.index') }}" class="btn reset-btn w-100">Reset</a>
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
                            <div class="card-header p-0">
                                <img class="img-fluid w-100"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    src="{{ asset('storage/' . $sellable->image) }}"
                                    alt="Immagine della pagina {{ $sellable->name }}">
                                <a href="{{ route('admin.sellables.show', $sellable->slug) }}"
                                    class="btn sellable-detail-btn position-absolute fs-5 top-0 end-0 me-2 mt-2 rounded-circle"><i
                                        class="fa-solid fa-magnifying-glass"></i></a>
                            </div>
                        @endif

                        {{-- Nome e Descrizione --}}
                        <div class="card-body d-flex flex-column py-2">
                            <h5 class="mt-2">{{ $sellable->name }}</h5>
                            <small>
                                @if ($sellable->category)
                                    {{ $sellable->category->name }}
                                @endif
                            </small>
                            <p class="card-text mt-3 mb-2">{{ $sellable->description }}</p>
                        </div>

                        {{-- Bottoni Modifica e Elimina --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn modify-btn" href="{{ route('admin.sellables.edit', $sellable) }}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $sellable->id }}">
                                <i class="fa-solid fa-trash-can"></i>
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
        <div class="mt-4">
            {{ $sellables->withQueryString()->links() }}
        </div>
        

    </div>

@endsection
