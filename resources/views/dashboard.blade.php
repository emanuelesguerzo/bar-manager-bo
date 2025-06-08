@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>

        @if ($lowStockProducts->count())
            <div class="alert alert-warning">
                <h5><i class="fa-solid fa-triangle-exclamation me-2"></i>Prodotti in esaurimento</h5>
                <ul class="">
                    @foreach ($lowStockProducts as $product)
                        <li class="mb-1">
                            {{ $product->name }} – {{ $product->units_in_stock }} unità rimaste
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
