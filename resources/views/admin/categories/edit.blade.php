@extends("layouts.app")

@section("title", "Modifica una categoria")

@section("content")
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route("admin.categories.index") }}" class="btn back-btn">
            ← Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="my-4">@yield("title")</h1>

        {{-- Form Categoria --}}
        <form class="form-box rounded p-3" action="{{ route("admin.categories.update", $category) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nome Categoria --}}
            <div class="mb-3">
                <label class="form-label label-required" for="name">Nome della categoria</label>
                <input class="form-control @error("name") is-invalid @enderror" type="text" name="name" id="name"
                    maxlength="255" value="{{ old("name", $category->name) }}" required>
                @error("name")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Descrizione Categoria --}}
            <div class="mb-4">
                <label class="form-label" for="description">Descrizione della categoria</label>
                <textarea class="form-control" type="text" name="description" id="description" rows="2" placeholder="Es: Prodotti tipici di una pizzeria...">{{ old("description", $category->description) }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-new w-100">Salva modifiche</button>
            </div>

        </form>    
    </div>
@endsection
