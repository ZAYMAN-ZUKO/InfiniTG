<section>
    <div class="panel-head">
        <h3><i data-lucide="lock" aria-hidden="true"></i> Update Password</h3>
    </div>
    <p class="text-sm muted" style="margin-bottom:16px">
        Ensure your account is using a long, random password to stay secure.
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="field">
            <label for="update_password_current_password">Current Password</label>
            <input class="input" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="update_password_password">New Password</label>
            <input class="input" id="update_password_password" name="password" type="password" autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <input class="input" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-between">
            <button class="btn btn-primary" type="submit">
                <i data-lucide="save" aria-hidden="true"></i>Save
            </button>

            @if (session('status') === 'password-updated')
                <span class="badge badge-success"><i data-lucide="check" aria-hidden="true"></i>Saved.</span>
            @endif
        </div>
    </form>
</section>
