@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h1 style="margin-bottom:25px;">Dashboard</h1>

<div class="cards">

    <div class="card">
        <h3>Total Files</h3>
        <h2>{{ $totalFiles ?? 0 }}</h2>
    </div>

    <div class="card">
        <h3>Storage Used</h3>
        <h2>{{ $storageUsed ?? '0 MB' }}</h2>
    </div>

    <div class="card">
        <h3>Favorites</h3>
        <h2>{{ $favoriteCount ?? 0 }}</h2>
    </div>

    <div class="card">
        <h3>Trash</h3>
        <h2>{{ $trashCount ?? 0 }}</h2>
    </div>

</div>

<div class="panel">

    <h2>Storage Usage</h2>

    <br>

    <div class="progress">
        <div class="bar" style="width: {{ $storagePercentage }}%;"></div>
    </div>

    <p style="margin-top:10px;">
        {{ $storagePercentage }}% Used
    </p>

</div>

@endsection