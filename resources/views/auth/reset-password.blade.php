<x-guest-layout>

<h2>Reset password</h2>
<p>Choose a new password for your account.</p>

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

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
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
        <i data-lucide="key-round" aria-hidden="true"></i>Reset Password
    </button>
</form>

</x-guest-layout>
