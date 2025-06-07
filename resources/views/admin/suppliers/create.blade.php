@extends('layouts.app')

@section('title', 'Aggiungi un nuovo fornitore')

@section('content')
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Form Fornitori --}}
        <form class="border rounded p-3" action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            {{-- Nome Fornitore --}}
            <div class="mb-3">
                <label class="form-label label-required" for="name">Nome del fornitore</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                    maxlength="255" value="{{ old('name') }}" placeholder="Es: Rabanser KG" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Mail Fornitore --}}
            <div class="mb-3">
                <label class="form-label" for="email">Email del fornitore</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                    id="email" placeholder="mario.rossi@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback ">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Telefono Fornitore --}}
            <div class="mb-4">
                <label class="form-label" for="phone">Telefono del fornitore</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone"
                    id="phone" pattern="^\+39\d{9,10}$" placeholder="+390000000000" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success w-100">Salva</button>
            </div>

        </form>

    </div>
@endsection
