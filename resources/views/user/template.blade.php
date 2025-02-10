@extends('layouts.app')

@section('auth')
    @include('layouts.navbars.auth.sidebar')
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        @include('layouts.navbars.auth.nav')
        @yield('content')
    </div>
    @include('layouts.footers.auth.footer')
@endsection
