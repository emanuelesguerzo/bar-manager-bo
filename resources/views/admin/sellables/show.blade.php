@extends("layouts.app")

@section("title", $sellable->name)

@section("content")
    <div class="container">

        {{-- Alert Successo --}}
        @if (session("success"))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session("success") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Torna indietro --}}
        <div class="mt-4">
            <a href="{{ route("admin.sellables.index") }}" class="btn back-btn">← Torna indietro</a>
        </div>

        {{-- Card --}}
        <div class="card d-flex flex-column mt-3">

            {{-- Immagine --}}
            @if ($sellable->image)
                <div class="card-header p-0 text-center">
                    <img class="img-fluid" style="max-width: 100%; width: 320px;"
                        src="{{ asset("storage/" . $sellable->image) }}" alt="Immagine della pagina {{ $sellable->name }}">
                </div>
            @endif

            {{-- Nome e Descrizione --}}
            <div class="card-body">
                <h5>{{ $sellable["name"] }}</h5>
                <p class="card-text mt-3">{{ $sellable["description"] }}</p>
            </div>

            {{-- Lista --}}
            <ul class="list-group list-group-flush">

                {{-- Prezzo --}}
                <li class="list-group-item"><strong class="text-muted">Prezzo:</strong> {{ $sellable->price }} €</li>

                {{-- Categoria --}}
                @if ($sellable->category)
                    <li class="list-group-item"><strong class="text-muted">Categoria:</strong> {{ $sellable->category->name }}</li>
                @endif

                {{-- Ingredienti --}}
                <li class="list-group-item">
                    <strong class="text-muted">Ingredienti:</strong>
                    @if ($sellable->products->isNotEmpty())
                        <ul class="mt-2">
                            @foreach ($sellable->products as $product)
                                <li>
                                    {{ $product->name }} - {{ $product->pivot->quantity }} {{ $product->pivot->unit }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-0">Nessun ingrediente specificato.</p>
                    @endif
                </li>

            </ul>

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

        {{-- Navigazione tra prodotti --}}
        <div class="d-flex justify-content-between my-4">
            <a href="{{ route("admin.sellables.show", $previous->slug) }}" class="btn back-btn">
                ← {{ $previous->name }}
            </a>
            <a href="{{ route("admin.sellables.show", $next->slug) }}" class="btn forward-btn">
                {{ $next->name }} →
            </a>
        </div>
    </div>

    {{-- Modale --}}
    <x-modal.delete-sellable :sellable="$sellable" />
    
@endsection
