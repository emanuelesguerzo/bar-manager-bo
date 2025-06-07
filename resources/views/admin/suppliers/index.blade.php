@extends('layouts.app')
@section('title', 'I nostri Fornitori')

@section('content')
    <div class="container">

        {{-- Alert Successo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Titolo Principale --}}
        <h1 class="my-4">@yield('title')</h1>

        <div class="d-flex justify-content-end my-3">
            <a class="btn btn-primary mb-3" href="{{ route('admin.suppliers.create') }}"><i class="fa-solid fa-plus me-2"></i>Nuovo</a>
        </div>

        <div class="row">
            @foreach ($suppliers as $supplier)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card h-100 mb-3">
                        <div class="card-header d-flex align-content-center">
                            <h5 class="card-title mb-0">{{ $supplier['name'] }}</h5>
                        </div>
                        @if ($supplier->email || $supplier->phone)
                            <div class="card-body d-flex justify-content-between align-items-center">
                                @if ($supplier->email)
                                    <a
                                        class="btn btn-outline-secondary"
                                        href="mailto:{{ $supplier['email'] }}?subject=Nuovo ordine&body=Buongiorno,%0A%0Aecco il nostro nuovo ordine:"><i class="fa-solid fa-envelope me-2"></i>Scrivi
                                        Mail</a>
                                @endif
                                @if ($supplier->phone)
                                    <a 
                                        class="btn btn-outline-secondary" 
                                        href="tel:{{ $supplier['phone'] }}">
                                        <i class="fa-solid fa-phone me-2"></i>Chiama
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="card-body text-muted fst-italic">
                                Nessun contatto disponibile
                            </div>
                        @endif
                        <div class="card-body d-flex justify-content-center p-0 mb-3">
                            <a href="{{ route('admin.suppliers.show', $supplier->slug) }}" class="mt-auto btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass me-2"></i>Prodotti
                                    associati</a>
                        </div>

                        
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
