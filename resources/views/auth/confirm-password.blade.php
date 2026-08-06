<x-guest-layout>

<h2>Confirm password</h2>
<p class="auth-note">
    This is a secure area of the application. Please confirm your password before continuing.
</p>

@if($errors->any())
    <div class="alert alert-danger">
        <i data-lucide="alert-circle" aria-hidden="true"></i>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="current-password" autofocus>
    </div>

    <button class="btn btn-primary btn-block" type="submit">
        <i data-lucide="shield-check" aria-hidden="true"></i>Confirm
    </button>
</form>

</x-guest-layout>
