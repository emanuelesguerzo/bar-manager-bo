@extends('layouts.app')
@section('content')

<div class="container">
    <h1 class="my-4">
        {{ __('Profilo') }}
    </h1>
    <div class="card p-4 mb-4 rounded-lg">

        @include('profile.partials.update-profile-information-form')

    </div>

    <div class="card p-4 mb-4 rounded-lg">


        @include('profile.partials.update-password-form')

    </div>

    <div class="card p-4 mb-4 rounded-lg">


        @include('profile.partials.delete-user-form')

    </div>
</div>

@endsection
