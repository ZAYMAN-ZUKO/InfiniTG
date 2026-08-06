<x-guest-layout>

<h2>Forgot your password?</h2>
<p>No problem. Enter your email and we'll send you a reset link.</p>

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

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <button class="btn btn-primary btn-block" type="submit">
        <i data-lucide="mail" aria-hidden="true"></i>Email Password Reset Link
    </button>
</form>

<p class="auth-alt">
    <a href="{{ route('login') }}">Back to login</a>
</p>

</x-guest-layout>
