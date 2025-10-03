@extends('layouts.admin_app')

@section('content')

    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

@endsection