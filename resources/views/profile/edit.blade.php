@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="pagehead">
    <div>
        <h1>Profile</h1>
        <p>Manage your account information, password and security.</p>
    </div>
</div>

<div class="settings-grid">
    <div class="panel">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="panel">
        @include('profile.partials.update-password-form')
    </div>

    <div class="panel">
        @include('profile.partials.delete-user-form')
    </div>
</div>

@endsection
