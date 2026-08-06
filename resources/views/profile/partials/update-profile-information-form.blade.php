<section>
    <div class="panel-head">
        <h3><i data-lucide="user" aria-hidden="true"></i> Profile Information</h3>
    </div>
    <p class="text-sm muted" style="margin-bottom:16px">
        Update your account's profile information and email address.
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="field">
            <label for="name">Name</label>
            <input class="input" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input class="input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="text-sm" style="margin-top:8px">
                    Your email address is unverified.
                    <button form="send-verification" class="link" type="submit">Click here to re-send the verification email.</button>
                </p>
            @endif
        </div>

        <div class="flex-between">
            <button class="btn btn-primary" type="submit">
                <i data-lucide="save" aria-hidden="true"></i>Save
            </button>

            @if (session('status') === 'profile-updated')
                <span class="badge badge-success"><i data-lucide="check" aria-hidden="true"></i>Saved.</span>
            @endif
        </div>
    </form>
</section>
