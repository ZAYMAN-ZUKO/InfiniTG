<x-guest-layout>

<h2>Create your account</h2>
<p>Start storing files for free — takes less than a minute.</p>

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

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="field">
        <label for="name">Name</label>
        <input class="input" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="new-password">
    </div>

    <div class="field">
        <label for="password_confirmation">Confirm Password</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button class="btn btn-primary btn-block" type="submit">
        <i data-lucide="user-plus" aria-hidden="true"></i>Register
    </button>
</form>

<p class="auth-alt">
    Already registered? <a href="{{ route('login') }}">Log in</a>
</p>

</x-guest-layout>
