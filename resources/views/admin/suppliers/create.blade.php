@extends('layouts.app')

@section('title', 'Inserisci un nuovo fornitore')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a class=" btn btn-primary" href="{{ route('admin.suppliers.index') }}">Torna ai fornitori</a>
        </div>

        {{-- Titolo Pagina --}}
        <h1 class="mt-3">@yield('title')</h1>

        {{-- Form Fornitori --}}
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            <div class="form-control d-flex flex-column mt-4 mb-3">

                <div class="py-2">

                    {{-- Nome Fornitore --}}
                    <label class="form-label fs-5" for="name">Nome del Fornitore</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" maxlength="255" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    
                    {{-- Mail Fornitore --}}
                    <label class="form-label fs-5 mt-3" for="email">Email del Fornitore</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="mario.rossi@gmail.com" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback ">
                        {{ $message }}
                    </div>
                    @enderror
                    
                    {{-- Telefono Fornitore --}}
                    <label class="form-label mt-3 fs-5" for="phone">Numero di telefono Fornitore</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" id="phone" pattern="^\+39\d{9,10}$" placeholder="+39..." value="{{ old('phone') }}">
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
                
            </div>

            {{-- Salva Progetto --}}
            <button type="submit" class="btn btn-primary">Salva</button>

        </form>
    </div>
@endsection
