@extends("layouts.app")
@section("title", "Le nostre Categorie")

@section("content")
    <div class="container">

        {{-- Alert Errore --}}
        @if (session("error"))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session("error") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Successo --}}
        @if (session("success"))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session("success") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between my-4 gap-2">

            {{-- Titolo Principale --}}
            <h1 class="m-0">@yield("title")</h1>

            {{-- Aggiungi Nuovo --}}
            <a class="btn btn-new ms-auto mt-2 mt-md-0" href="{{ route("admin.categories.create") }}"><i class="fa-solid fa-plus me-2"></i>Nuovo</a>

        </div>

        {{-- Grid --}}
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card h-100 mb-3">
                        <div class="card-header d-flex align-content-center">
                            <h5 class="mb-0">{{ $category->name }}</h5>
                        </div>

                        {{-- Descrizione --}}
                        <div class="card-body d-flex flex-column">
                            @if ($category->description)
                                <p>{{ $category->description }}</p>
                            @else
                                <p class="fst-italic">Nessuna descrizione disponibile</p>
                            @endif

                            {{-- Prodotti associati --}}
                            <a href="{{ route("admin.categories.show", $category->slug) }}"
                                class="mt-auto btn btn-new"><i
                                    class="fa-solid fa-magnifying-glass me-2"></i>Prodotti
                                associati</a>
                        </div>

                        {{-- Bottoni Modifica e Elimina --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn modify-btn"
                                href="{{ route("admin.categories.edit", $category) }}"><i
                                    class="fa-solid fa-pencil"></i></a>
                            <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $category->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modale --}}
                <x-modal.delete-category :category="$category" />
            @endforeach
        </div>
    </div>
@endsection
