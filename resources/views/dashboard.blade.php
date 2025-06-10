@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">
            {{ __('Dashboard') }}
        </h1>

        @if ($lowStockProducts->count())
            <div class="alert alert-dashboard rounded-5">
                <h5><i class="fa-solid fa-triangle-exclamation me-2"></i>Prodotti in esaurimento</h5>
                <ul class="mb-0">
                    @foreach ($lowStockProducts as $product)
                        <li class="mb-1">
                            {{ $product->name }} - <strong class="text-muted">{{ $product->units_in_stock }}</strong> unità rimaste
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
