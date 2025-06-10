@extends("layouts.app")

@section("title", "I nostri prodotti")

@section("content")
    <div class="container mt-3">

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

        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between my-4 gap-2">

            {{-- Titolo Principale --}}
            <h1 class="m-0">@yield("title")</h1>

            {{-- Aggiungi Nuovo --}}
            <a class="btn btn-new ms-auto mt-2 mt-md-0" href="{{ route("admin.products.create") }}">
                <i class="fa-solid fa-plus me-2"></i>Nuovo
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route("admin.products.index") }}" class="form-box rounded p-2 mb-3">
            <div class="row g-2 align-items-end">

                {{-- Campo ricerca --}}
                <div class="col-md-8">
                    <label for="search" class="form-label">Cerca per nome o marca</label>
                    <input type="text" name="search" id="search" value="{{ request("search") }}" class="form-control"
                        placeholder="Es: Prosecco...">
                </div>

                {{-- Bottoni Cerca e Reset --}}
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn search-btn w-100" type="submit">Cerca</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route("admin.products.index") }}" class="btn reset-btn w-100">Reset</a>
                </div>
            </div>
        </form>


        {{-- Grid --}}
        <div class="row">
            @foreach ($products as $product)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card d-flex flex-column justify-content-between">

                        {{-- Immagine --}}
                        @if ($product->image)
                            <div class="card-header">
                                <img class="img-fluid w-100 rounded" style="height: 180px; object-fit: cover;"
                                    src="{{ asset("storage/" . $product->image) }}"
                                    alt="Immagine del prodotto {{ $product->name }}">
                            </div>
                        @endif

                        {{-- Nome, Marca, Dettagli --}}
                        <div class="card-body d-flex align-items-center justify-content-between py-2">
                            <div>
                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                @if ($product->brand)
                                    <small class="text-muted">{{ $product->brand }}</small>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route("admin.products.show", $product->slug) }}"
                                    class="btn btn-new btn-sm rounded-circle"><i
                                        class="fa-solid fa-magnifying-glass"></i></a>
                            </div>
                        </div>

                        {{-- Prezzo e unita' in magazzino --}}
                        <ul class="list-group list-group-flush mt-auto">
                            <li class="list-group-item"><strong>Prezzo:</strong> {{ $product->price }}€
                                @if ($product->unit_size_ml)
                                    <span class="text-muted">/ {{ $product->unit_size_ml }} ml</span>
                                @endif
                                @if ($product->unit_size_g)
                                    <span class="text-muted">/ {{ $product->unit_size_g }} g</span>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <strong>In magazzino:</strong> <span
                                    class="text-muted">{{ $product->units_in_stock }} unità</span>
                            </li>

                            {{-- Stock e unità se presenti --}}
                            @if ($product->stock_ml)
                                <li class="list-group-item"><strong>Stock:</strong> <span
                                        class="text-muted">{{ $product->stock_ml }} ml</span></li>
                            @endif

                            @if ($product->stock_g)
                                <li class="list-group-item"><strong>Stock:</strong> <span
                                        class="text-muted">{{ $product->stock_g }} g</span></li>
                            @endif

                            {{-- Carico e scarico merce magazzino --}}
                            <li class="list-group-item p-0">
                                <div class="accordion" id="accordion-{{ $product->id }}">
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="heading-{{ $product->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-{{ $product->id }}"
                                                aria-expanded="false" aria-controls="collapse-{{ $product->id }}">
                                                Gestione magazzino
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $product->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $product->id }}"
                                            data-bs-parent="#accordion-{{ $product->id }}">
                                            <div class="accordion-body">
                                                
                                                {{-- Aggiungi stock --}}
                                                <form method="POST"
                                                    action="{{ route("admin.products.addStock", $product) }}"
                                                    class="mb-2">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="number" name="new_units" min="1"
                                                            class="form-control flex-grow-1" placeholder="Unità">
                                                        <button class="btn add-btn w-btn">+ Aggiungi</button>
                                                    </div>
                                                </form>

                                                {{-- Scarica stock --}}
                                                <form method="POST"
                                                    action="{{ route("admin.products.removeStock", $product) }}">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="number" name="remove_units" min="1"
                                                            max="{{ $product->units_in_stock }}"
                                                            class="form-control flex-grow-1" placeholder="Unità">
                                                        <button class="btn confirm-delete-btn w-btn">- Scarica</button>
                                                    </div>
                                                </form>

                                                {{-- Scarico completo --}}
                                                <form method="POST"
                                                    action="{{ route("admin.products.clearStock", $product) }}">
                                                    @csrf
                                                    <button type="button" class="btn confirm-delete-btn w-100 mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#clearStockModal-{{ $product->id }}">
                                                        <i class="fa-solid fa-arrows-rotate me-2"></i> Scarico completo
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>

                        {{-- Bottoni Modifica e Elimina --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn modify-btn" href="{{ route("admin.products.edit", $product) }}"><i
                                    class="fa-solid fa-pencil"></i></a>
                            <button type="button" class="btn delete-btn" data-bs-toggle="modal"
                                data-bs-target="#destroyModal-{{ $product->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Modali --}}
                <x-modal.delete-product :product="$product" />
                <x-modal.clear-stock :product="$product" />

            @endforeach

            {{-- Lista Vuota --}}
            @if ($products->isEmpty())
                <div class="alert alert-warning text-center my-4">
                    Nessun prodotto corrisponde alla ricerca.
                </div>
            @endif

        </div>

        {{-- Paginazione --}}
        <div class="mt-3 mb-2">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>
@endsection
