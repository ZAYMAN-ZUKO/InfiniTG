<section>
    <div class="panel-head">
        <h3><i data-lucide="trash" aria-hidden="true"></i> Delete Account</h3>
    </div>
    <p class="text-sm muted" style="margin-bottom:16px">
        Once your account is deleted, all of its resources and data will be permanently deleted.
        Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
        @csrf
        @method('delete')

        <div class="field">
            <label for="password">Password</label>
            <input class="input" id="password" name="password" type="password" placeholder="Enter your password to confirm" autocomplete="current-password">
            @error('password', 'userDeletion')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <button class="btn btn-danger" type="submit">
            <i data-lucide="trash-2" aria-hidden="true"></i>Delete Account
        </button>
    </form>
</section>
