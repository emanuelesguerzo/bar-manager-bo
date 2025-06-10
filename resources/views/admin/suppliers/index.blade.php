@extends('layouts.app')
@section('title', 'I nostri Fornitori')

@section('content')
    <div class="container">

        {{-- Alert Errore --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Successo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between my-4 gap-2">
            {{-- Titolo Principale --}}
            <h1 class="m-0">@yield('title')</h1>

            {{-- Aggiungi Nuovo --}}

            <a class="btn btn-new ms-auto mt-2 mt-md-0" href="{{ route('admin.suppliers.create') }}"><i
                    class="fa-solid fa-plus me-2"></i>Nuovo</a>

        </div>

        {{-- Grid --}}
        <div class="row">
            @foreach ($suppliers as $supplier)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card h-100 mb-3">

                        {{-- Nome Fornitore --}}
                        <div class="card-header d-flex align-content-center">
                            <h5 class="card-title mb-0">{{ $supplier->name }}</h5>
                        </div>

                        {{-- Email e Telefono --}}
                        @if ($supplier->email || $supplier->phone)
                            <div class="card-body d-flex justify-content-between align-items-center">
                                @if ($supplier->email)
                                    <a class="btn btn-new"
                                        href="mailto:{{ $supplier->email }}?subject=Nuovo ordine&body=Buongiorno,%0A%0Aecco il nostro nuovo ordine:"><i
                                            class="fa-solid fa-envelope me-2"></i>Scrivi
                                        Mail</a>
                                @endif
                                @if ($supplier->phone)
                                    <a class="btn btn-new" href="tel:{{ $supplier->phone }}">
                                        <i class="fa-solid fa-phone me-2"></i>Chiama
                                    </a>
                                @endif
                            </div>

                            {{-- Nessuno Contatto --}}
                        @else
                            <div class="card-body text-muted fst-italic">
                                Nessun contatto disponibile
                            </div>
                        @endif

                        {{-- Link ai prodotti associati --}}
                        <div class="card-body d-flex justify-content-center p-0 mb-3">
                            <a href="{{ route('admin.suppliers.show', $supplier->slug) }}"
                                class="mt-auto btn btn-new"><i
                                    class="fa-solid fa-magnifying-glass me-2"></i>Prodotti
                                associati</a>
                        </div>

                        {{-- Bottoni Modifica e Elimina --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn modify-btn"
                                href="{{ route('admin.suppliers.edit', $supplier) }}"><i
                                    class="fa-solid fa-pencil"></i></a>
                            <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $supplier->id }}">
                                 <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modale Elimina --}}
                <x-modal.delete-supplier :supplier="$supplier" />

            @endforeach
        </div>
    </div>
@endsection
