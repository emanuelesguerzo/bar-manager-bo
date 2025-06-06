@extends('layouts.app')
@section('title', 'I nostri Fornitori')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="my-4">@yield('title')</h1>

        <div>
            <a class="btn btn-primary mb-3" href="{{ route('admin.suppliers.create') }}">+ Aggiungi un nuovo fornitore</a>
        </div>

        <div class="row">
            @foreach ($suppliers as $supplier)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card h-100 mb-3">
                        <div class="card-header d-flex align-content-center">
                            <h5 class="mb-0">{{ $supplier['name'] }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.suppliers.show', $supplier->slug) }}" class="mt-auto">Vedi Prodotti
                                    associati</a>
                        </div>

                        
                        @if ($supplier->email || $supplier->phone)
                            <div class="card-body d-flex flex-column">
                                @if ($supplier->email)
                                    <a
                                        href="mailto:{{ $supplier['email'] }}?subject=Nuovo ordine&body=Buongiorno,%0A%0Aecco il nostro nuovo ordine:">Scrivi
                                        Mail</a>
                                @endif
                                @if ($supplier->phone)
                                    <a href="tel:{{ $supplier['phone'] }}">Chiama</a>
                                @endif
                            </div>
                        @else
                            <div class="card-body text-muted fst-italic">
                                Nessun contatto disponibile
                            </div>
                        @endif
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-outline-success" href="{{ route('admin.suppliers.edit', $supplier) }}">Modifica</a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $supplier->id }}">
                                Elimina
                            </button>
                        </div>
                    </div>
                </div>
                <x-modal.delete-supplier :supplier="$supplier" />
            @endforeach
        </div>
    </div>
@endsection
