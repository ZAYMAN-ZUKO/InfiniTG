<x-guest-layout>

<h2>Welcome back</h2>
<p>Log in to your InfiniTG account.</p>

@if(session('status'))
    <div class="alert alert-success">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

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

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="current-password">
    </div>

    <div class="auth-links">
        <label class="check">
            <input type="checkbox" name="remember" id="remember_me">
            Remember me
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot password?</a>
        @endif
    </div>

    <button class="btn btn-primary btn-block" type="submit" style="margin-top:20px">
        <i data-lucide="log-in" aria-hidden="true"></i>Log in
    </button>
</form>

<p class="auth-alt">
    Don't have an account? <a href="{{ route('register') }}">Create one</a>
</p>

</x-guest-layout>
