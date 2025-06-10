@extends("layouts.app")

@section("title", "Prodotti della categoria $category->name")

@section("content")
    <div class="container mt-3">

        {{-- Bottone Ritorno --}}
        <a href="{{ route("admin.categories.index") }}" class="btn back-btn">
            ← Torna indietro
        </a>

        {{-- Titolo Pagina --}}
        <h1 class="mt-4 mb-3">@yield("title")</h1>

        {{-- Descrizione Categoria --}}
        <p class=" mb-4">{{ $category->description }}</p>

        {{-- Grid --}}
        <div class="row">
            @foreach ($sellables as $sellable)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card h-100 d-flex flex-column justify-content-between">

                        {{-- Immagine --}}
                        @if ($sellable->image)
                            <div class="card-header p-0">
                                <img class="img-fluid w-100"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    src="{{ asset("storage/" . $sellable->image) }}"
                                    alt="Immagine della pagina {{ $sellable->name }}">
                                <a href="{{ route("admin.sellables.show", $sellable->slug) }}"
                                    class="btn btn-new position-absolute top-0 end-0 me-2 mt-2 rounded-circle"><i
                                        class="fa-solid fa-magnifying-glass"></i></a>
                            </div>
                        @endif

                        {{-- Nome e Descrizione --}}
                        <div class="card-body d-flex flex-column py-2">
                            <h5 class="mt-2">{{ $sellable->name }}</h5>
                            <small>
                                @if ($sellable->category)
                                    {{ $sellable->category->name }}
                                @endif
                            </small>
                            <p class="card-text mt-3 mb-2">{{ $sellable->description }}</p>
                        </div>

                        {{-- Bottoni Modifica e Elimina --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn modify-btn" href="{{ route("admin.sellables.edit", $sellable) }}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $sellable->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- Nessuno Prodotto --}}
            @if ($sellables->isEmpty())
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto associato a questa categoria.
                </div>
            @endif
            
        </div>
    </div>
@endsection
