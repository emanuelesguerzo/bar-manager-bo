@extends('layouts.app')

@section('title', 'Modifica una categoria')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a class=" btn btn-primary" href="{{ route('admin.categories.index') }}">Torna alle categorie</a>
        </div>

        {{-- Titolo Pagina --}}
        <h1 class="mt-3">@yield('title')</h1>

        {{-- Form Categoria --}}
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="form-control d-flex flex-column mt-4 mb-3">

                <div class="py-2">

                    {{-- Nome Categoria --}}
                    <label class="form-label fs-5" for="name">Nome della categoria</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" maxlength="255" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    
                    {{-- Descrizione Categoria --}}
                    <label class="form-label fs-5 mt-3" for="description">Descrizione della categoria</label>
                    <textarea class="form-control" type="text" name="description" id="description" rows="2">{{ old('description', $category->description) }}</textarea>

                </div>
                
            </div>

            {{-- Salva Progetto --}}
            <button type="submit" class="btn btn-primary">Salva</button>

        </form>
    </div>
@endsection