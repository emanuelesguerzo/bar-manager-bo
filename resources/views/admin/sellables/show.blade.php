@extends('layouts.app')

@section('title', $sellable->name)

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="mt-4">
            <a href="{{ route('admin.sellables.index') }}" class="btn btn-secondary mb-3">← Torna indietro</a>
        </div>
        <div class="card h-100 d-flex flex-column mt-1">
            @if ($sellable->image)
                <div class="card-header text-center">
                    <img 
                        class="img-fluid rounded"
                        style="max-width: 100%; width: 400px; object-fit: cover;"
                        src="{{ asset('storage/' . $sellable->image) }}" 
                        alt="Immagine della pagina {{ $sellable->name }}"
                    >
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $sellable['name'] }}</h5>
                <p class="card-text">{{ $sellable['description'] }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Prezzo: {{ $sellable['price'] }} €</li>
                <li class="list-group-item">{{ $sellable->category->name }}</li>
            </ul>
            <div class="card-body">
                <a class="btn btn-outline-success" href="{{ route('admin.sellables.edit', $sellable) }}">Modifica</a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#destroyModal-{{ $sellable->id }}">
                    Elimina
                </button>
            </div>
        </div>
        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('admin.sellables.show', $previous->slug) }}" class="btn btn-outline-secondary">
                ← {{ $previous->name }}
            </a>
            <a href="{{ route('admin.sellables.show', $next->slug) }}" class="btn btn-outline-secondary">
                {{ $next->name }} →
            </a>
        </div>
    </div>
    <x-modal.delete-sellable :sellable="$sellable" />
@endsection
