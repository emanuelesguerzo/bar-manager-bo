@extends('layouts.app')

@section('title', "Prodotti della categoria $category->name")

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">← Torna indietro</a>
    </div>

    <h1 class="mb-4">@yield("title")</h1>
    <p class="text-muted">{{ $category->description }}</p>

    <h4 class="mt-5">Prodotti associati:</h4>
    <div class="row">
        @forelse ($category->sellables as $sellable)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    @if ($sellable->image)
                        <img 
                            src="{{ asset('storage/' . $sellable->image) }}"
                            class="card-img-top"
                            style="object-fit: cover; height: 200px;"
                            alt="Immagine di {{ $sellable->name }}"
                        >
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $sellable->name }}</h5>
                        <p class="card-text py-1">{{ $sellable->description }}</p>
                        <p class="card-text mt-auto"><strong>Prezzo:</strong> {{ $sellable->price }}€</p>
                        <a href="{{ route('admin.sellables.show', $sellable) }}" class="btn btn-outline-primary mt-auto">Dettagli</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Nessun prodotto associato a questa categoria.</p>
        @endforelse
    </div>
</div>
@endsection