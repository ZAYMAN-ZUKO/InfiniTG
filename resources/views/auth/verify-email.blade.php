<x-guest-layout>

<h2>Verify your email</h2>
<p class="auth-note">
    Thanks for signing up! Before getting started, please verify your email address
    by clicking the link we just sent you. If you didn't receive it, we'll gladly send another.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert alert-success">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>A new verification link has been sent to your email address.</span>
    </div>
@endif

<div class="auth-verify-actions">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary" type="submit">
            <i data-lucide="mail" aria-hidden="true"></i>Resend Verification Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-ghost" type="submit">
            <i data-lucide="log-out" aria-hidden="true"></i>Log Out
        </button>
    </form>
</div>

</x-guest-layout>
