@extends('layouts.app')

@section('title', 'Il nostro menù')

@section('content')
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="my-4">@yield('title')</h1>
        <form method="GET" action="{{ route('admin.sellables.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cerca per nome...">
                <button class="btn btn-primary" type="submit">Cerca</button>
            </div>
        </form>

        <div>
            <a class="btn btn-primary mb-3" href="{{ route('admin.sellables.create') }}">+ Aggiungi un nuovo articolo</a>
        </div>

        <div class="row">
            @foreach ($sellables as $sellable)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card h-100 d-flex flex-column">
                        @if ($sellable->image)
                            <div class="card-header">
                                <img class="img-fluid w-100" style="height: 200px; object-fit: cover; object-position: center;"
                                    src="{{ asset('storage/' . $sellable->image) }}"
                                    alt="Immagine della pagina {{ $sellable->name }}">
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $sellable['name'] }}</h5>
                            <p class="card-text">{{ $sellable['description'] }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Prezzo: {{ $sellable['price'] }} €</li>
                            <li class="list-group-item">{{ $sellable->category->name }}</li>
                            <li class="list-group-item"><a href="{{ route('admin.sellables.show', $sellable->slug) }}" class="">Dettagli</a></li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        {{ $sellables->withQueryString()->links() }}
    </div>

@endsection
