@extends('layouts.app')

@section('title', 'Il nostro menù')

@section('content')
    <div class="container mt-3">
        <h1 class="my-4">@yield('title')</h1>
        <form method="GET" action="{{ route('admin.sellables.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cerca per nome...">
                <button class="btn btn-primary" type="submit">Cerca</button>
            </div>
        </form>

        <div class="row">
            @foreach ($sellables as $sellable)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="card h-100 d-flex flex-column">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sellable["name"] }}</h5>
                            <p class="card-text">{{$sellable["description"]}}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Prezzo: {{ $sellable["price"] }} €</li>
                            <li class="list-group-item">{{ $sellable->category->name }}</li>
                            <li class="list-group-item">A third item</li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                @endforeach

        </div>
        {{ $sellables->withQueryString()->links() }}
    </div>

@endsection
