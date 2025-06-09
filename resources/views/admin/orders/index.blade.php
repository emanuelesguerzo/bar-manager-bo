@extends('layouts.app')

@section('title', 'I nostri ordini')

@section('content')
    <div class="container mt-3">

        {{-- Alert Successo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Titolo Principale --}}
        <h1 class="my-4">@yield('title')</h1>

        {{-- Filtra per stato --}}
        <form method="GET" class="mb-3">
            <div class="input-group">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="inviato" {{ $status == 'inviato' ? 'selected' : '' }}>Inviato</option>
                    <option value="preparazione" {{ $status == 'preparazione' ? 'selected' : '' }}>In preparazione</option>
                    <option value="servito" {{ $status == 'servito' ? 'selected' : '' }}>Servito</option>
                    <option value="chiuso" {{ $status == 'chiuso' ? 'selected' : '' }}>Chiuso</option>
                </select>
            </div>
        </form>

        {{-- Grid --}}
        <div class="row">
            @if ($orders->isEmpty())
                <div class="alert alert-warning">
                    Nessun ordine disponibile.
                </div>
            @endif
            @foreach ($orders as $order)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    {{-- Card --}}
                    <div class="card h-100  border rounded">

                        {{-- Numero Tavolo e data e ora ordine --}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-utensils me-2"></i> Tavolo {{ $order->table_number }}
                            </h5>
                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>

                        {{-- List --}}
                        <ul class="list-group list-group-flush">

                            @foreach ($order->sellables as $sellable)
                                {{-- Prodotto ordinato e prezzo --}}
                                <li class="list-group-item">
                                    <strong>{{ $sellable->name }}</strong> x{{ $sellable->pivot->quantity }}
                                    – {{ number_format($sellable->price * $sellable->pivot->quantity, 2) }} €
                                </li>
                            @endforeach

                            {{-- Prezzo totale ordine --}}
                            <li class="list-group-item ">
                                <p class="fw-bold mb-0">Totale: {{ number_format($order->total, 2) }} €</p>
                            </li>

                            {{-- Form stato ordine --}}
                            <li class="list-group-item mt-auto">
                                <form method="POST" action="{{ route('admin.orders.update', $order) }}"
                                    class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="mb-0 fw-semibold">Stato:</label>
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        @foreach (['inviato', 'preparazione', 'servito', 'chiuso'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $order->status === $status ? 'selected' : '' }}>
                                                
                                                {{-- Serve per avere la lettere iniziale in maiuscolo --}}
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            @endforeach
            <div class="mt-4">
                {{-- Navigazione (Mantengo filtro attivo mentre navigo) --}}
                {{ $orders->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
@endsection
