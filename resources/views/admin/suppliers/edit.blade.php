@extends('layouts.app')

@section('title', 'Modifica un fornitore')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a class=" btn btn-primary" href="{{ route('admin.suppliers.index') }}">Torna ai fornitori</a>
        </div>

        {{-- Titolo Pagina --}}
        <h1 class="mt-3">@yield('title')</h1>

        {{-- Form Fornitori --}}
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="form-control d-flex flex-column mt-4 mb-3">

                <div class="py-2">

                    {{-- Nome Fornitore --}}
                    <label class="form-label fs-5" for="name">Nome del Fornitore</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" maxlength="255" value="{{ $supplier->name }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    
                    {{-- Mail Fornitore --}}
                    <label class="form-label fs-5 mt-3" for="email">Email del Fornitore</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="mario.rossi@gmail.com" value="{{ old('email', $supplier->email) }}">
                    @error('email')
                    <div class="invalid-feedback ">
                        {{ $message }}
                    </div>
                    @enderror
                    
                    {{-- Telefono Fornitore --}}
                    <label class="form-label mt-3 fs-5" for="phone">Numero di telefono del Fornitore</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="tel" name="phone" id="phone" pattern="^\+39\d{9,10}$" placeholder="+39..." value="{{ old('phone', $supplier->phone) }}">
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