@extends('layouts.app')
@section('title', 'Le nostre Categorie')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="my-4">@yield('title')</h1>

        <div>
            <a class="btn btn-primary mb-3" href="{{ route('admin.categories.create') }}">+ Aggiungi una nuova categoria</a>
        </div>

        <div class="row">
            @foreach ($categories as $category)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card h-100 mb-3">
                        <div class="card-header d-flex align-content-center">
                            <h5 class="mb-0">{{ $category['name'] }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            @if ($category->description)
                                <p>{{ $category['description'] }}</p>
                            @else
                                <p class="text-muted fst-italic">Nessuna descrizione disponibile</p>
                            @endif

                            <a href="{{ route('admin.categories.show', $category->slug) }}" class="mt-auto">Vedi Prodotti
                                associati</a>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-outline-success"
                                href="{{ route('admin.categories.edit', $category) }}">Modifica</a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $category->id }}">
                                Elimina
                            </button>
                        </div>
                    </div>
                </div>
                <x-modal.delete-category :category="$category" />
            @endforeach
        </div>
    </div>
@endsection
