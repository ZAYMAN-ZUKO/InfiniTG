@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="pagehead">
    <div>
        <h1>Settings</h1>
        <p>Manage your account, storage and Telegram connection.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" data-toast="{{ session('success') }}">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="settings-grid">

    {{-- Profile --}}
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="user" aria-hidden="true"></i> Profile</h3>
        </div>
        <table class="info-table">
            <tr>
                <td>Name</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Member since</td>
                <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Storage --}}
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="hard-drive" aria-hidden="true"></i> Storage Information</h3>
        </div>

        <div class="unlimited-storage-panel">
            <div class="unlimited-storage-highlight">
                <i data-lucide="infinity" aria-hidden="true"></i>
                <div>
                    <strong>Unlimited</strong>
                    <span>Storage</span>
                </div>
            </div>
            <p class="unlimited-storage-used">{{ $storageUsed ?? 0 }} MB currently used</p>
            <div class="unlimited-storage-powered">
                <i data-lucide="send" aria-hidden="true"></i>
                <span>Powered by Telegram</span>
            </div>
        </div>

        <table class="info-table" style="margin-top:14px">
            <tr>
                <td>Total Files</td>
                <td>{{ $totalFiles }}</td>
            </tr>
            <tr>
                <td>Favorite Files</td>
                <td>{{ $favoriteCount }}</td>
            </tr>
            <tr>
                <td>Trash Files</td>
                <td>{{ $trashCount }}</td>
            </tr>
        </table>
    </div>

    {{-- Telegram --}}
    <div class="panel" id="telegram-panel">
        <div class="panel-head">
            <h3><i data-lucide="send" aria-hidden="true"></i> Telegram Account</h3>
            <span id="telegram-state-badge" class="badge {{ $telegramConnected ? 'badge-success' : 'badge-warn' }}">
                <i data-lucide="{{ $telegramConnected ? 'check' : 'alert-circle' }}" aria-hidden="true"></i>{{ $telegramConnected ? 'Connected' : 'Not Connected' }}
            </span>
        </div>

        <div id="telegram-connected-state" class="{{ $telegramConnected ? '' : 'is-hidden' }}">
            <div class="tg-status">
                <i data-lucide="check-circle" aria-hidden="true"></i>
                <div>
                    <b>Telegram Connected</b>
                    <span>Your Telegram account is successfully connected and ready to use.</span>
                </div>
            </div>

            <table class="info-table">
                <tr>
                    <td>Phone Number</td>
                    <td id="telegram-phone-display">{{ $telegramPhone ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Connected On</td>
                    <td id="telegram-connected-at-display">{{ $telegramConnectedAt ? $telegramConnectedAt->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>
            </table>

            <div style="margin-top:16px">
                <button class="btn btn-ghost btn-block" type="button" id="disconnect-tg-btn">
                    <i data-lucide="unplug" aria-hidden="true"></i>Disconnect Telegram
                </button>
            </div>
        </div>

        <div id="telegram-disconnected-state" class="{{ $telegramConnected ? 'is-hidden' : '' }}">
            <div class="tg-status tg-off">
                <i data-lucide="zap" aria-hidden="true"></i>
                <div>
                    <b>Telegram integration ready</b>
                    <span>Connect your Telegram account to power your cloud storage.</span>
                </div>
            </div>

            <div class="field">
                <label for="phone">Phone Number</label>
                <input class="input" type="text" id="phone" placeholder="+8801XXXXXXXXX" autocomplete="tel">
            </div>

            <button class="btn btn-primary btn-block" id="send-code-btn" type="button">
                <i data-lucide="message-circle" aria-hidden="true"></i>Send Code
            </button>

            <div class="field" style="margin-top:16px">
                <label for="telegram-code">Verification Code</label>
                <input class="input" type="text" id="telegram-code" placeholder="Enter Telegram OTP" autocomplete="one-time-code">
            </div>

            <button class="btn btn-soft btn-block" id="verify-code-btn" type="button">
                <i data-lucide="shield-check" aria-hidden="true"></i>Verify Code
            </button>

            <div id="tg-response" class="is-hidden" style="margin-top:14px"></div>

            <div class="note">
                <i data-lucide="info" aria-hidden="true"></i>
                <span>A one-time code will be sent to your Telegram. Two-step verification (2FA) passwords are supported during login.</span>
            </div>
        </div>
   </div>

   {{-- Security --}}
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="shield" aria-hidden="true"></i> Security</h3>
        </div>
        <p class="text-sm muted" style="margin-bottom:14px">
            Your password is securely hashed and encrypted. Account security is handled by Laravel's battle-tested auth system.
        </p>
        <button class="btn btn-ghost" type="button" disabled>
            <i data-lucide="lock" aria-hidden="true"></i>Change Password (Coming Soon)
        </button>
    </div>

    {{-- About --}}
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="info" aria-hidden="true"></i> About</h3>
        </div>
        <table class="info-table">
            <tr>
                <td>Application</td>
                <td>InfiniTG</td>
            </tr>
            <tr>
                <td>Version</td>
                <td>v1.0 Beta</td>
            </tr>
            <tr>
                <td>Framework</td>
                <td>Laravel {{ app()->version() }}</td>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td>{{ PHP_VERSION }}</td>
            </tr>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
(function () {
    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var responseBox = document.getElementById('tg-response');

    function setStatus(data, ok) {
        if (!responseBox) return;
        responseBox.classList.remove('is-hidden');
        var cls = ok ? 'alert alert-success' : 'alert alert-danger';
        responseBox.className = cls;
        responseBox.innerHTML = '<i data-lucide="' + (ok ? 'check-circle' : 'alert-circle') + '" aria-hidden="true"></i><span></span>';
        responseBox.querySelector('span').textContent = data.message || 'Something went wrong.';
        if (window.lucide) { lucide.createIcons(); }
    }

    async function post(url, payload) {
        var res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: payload ? JSON.stringify(payload) : null
        });
        return res.json();
    }

    function showConnectedState(data) {
        var connectedState = document.getElementById('telegram-connected-state');
        var disconnectedState = document.getElementById('telegram-disconnected-state');
        var badge = document.getElementById('telegram-state-badge');
        var phoneDisplay = document.getElementById('telegram-phone-display');
        var connectedAtDisplay = document.getElementById('telegram-connected-at-display');

        if (connectedState) connectedState.classList.remove('is-hidden');
        if (disconnectedState) disconnectedState.classList.add('is-hidden');
        if (badge) {
            badge.className = 'badge badge-success';
            badge.innerHTML = '<i data-lucide="check" aria-hidden="true"></i>Connected';
        }
        if (phoneDisplay) phoneDisplay.textContent = data.user && data.user.phone ? data.user.phone : '-';
        if (connectedAtDisplay) connectedAtDisplay.textContent = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        if (responseBox) responseBox.classList.add('is-hidden');
        if (window.lucide) { lucide.createIcons(); }
    }

    function showDisconnectedState() {
        var connectedState = document.getElementById('telegram-connected-state');
        var disconnectedState = document.getElementById('telegram-disconnected-state');
        var badge = document.getElementById('telegram-state-badge');
        var phoneInput = document.getElementById('phone');
        var codeInput = document.getElementById('telegram-code');

        if (connectedState) connectedState.classList.add('is-hidden');
        if (disconnectedState) disconnectedState.classList.remove('is-hidden');
        if (badge) {
            badge.className = 'badge badge-warn';
            badge.innerHTML = '<i data-lucide="alert-circle" aria-hidden="true"></i>Not Connected';
        }
        if (phoneInput) phoneInput.value = '';
        if (codeInput) codeInput.value = '';
        if (responseBox) {
            responseBox.classList.add('is-hidden');
            responseBox.innerHTML = '';
        }
        if (window.lucide) { lucide.createIcons(); }
    }

    var sendBtn = document.getElementById('send-code-btn');
    if (sendBtn) {
        sendBtn.addEventListener('click', async function () {
            var btn = this;
            btn.disabled = true;
            var phone = document.getElementById('phone').value.trim();
            if (!phone) {
                setStatus({ message: 'Please enter your phone number.' }, false);
                btn.disabled = false;
                return;
            }
            var data = await post('{{ route('telegram.send-code') }}', { phone: phone });
            setStatus(data, !!data.success);
            btn.disabled = false;
        });
    }

    var verifyBtn = document.getElementById('verify-code-btn');
    if (verifyBtn) {
        verifyBtn.addEventListener('click', async function () {
            var btn = this;
            btn.disabled = true;
            var code = document.getElementById('telegram-code').value.trim();
            if (!code) {
                setStatus({ message: 'Please enter the verification code.' }, false);
                btn.disabled = false;
                return;
            }
            var data = await post('{{ route('telegram.verify-code') }}', { code: code });
            if (data.requires_password) {
                var password = prompt('Two-step verification is enabled. Enter your Telegram password:');
                if (password) {
                    data = await post('{{ route('telegram.verify-password') }}', { password: password });
                }
            }
            setStatus(data, !!data.success);
            btn.disabled = false;
            if (data.success && data.user) showConnectedState(data);
        });
    }

    var disconnectBtn = document.getElementById('disconnect-tg-btn');
    if (disconnectBtn) {
        disconnectBtn.addEventListener('click', async function () {
            var btn = this;
            if (!confirm('Disconnect your Telegram account? You will need to reconnect to continue using Telegram storage.')) return;
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader" aria-hidden="true"></i>Disconnecting...';
            if (window.lucide) { lucide.createIcons(); }

            try {
                var data = await post('{{ route('telegram.logout') }}');
                if (data.success) {
                    showDisconnectedState();
                } else {
                    setStatus(data, false);
                    btn.disabled = false;
                    btn.innerHTML = '<i data-lucide="unplug" aria-hidden="true"></i>Disconnect Telegram';
                    if (window.lucide) { lucide.createIcons(); }
                }
            } catch (e) {
                setStatus({ message: 'Disconnect request failed.' }, false);
                btn.disabled = false;
                btn.innerHTML = '<i data-lucide="unplug" aria-hidden="true"></i>Disconnect Telegram';
                if (window.lucide) { lucide.createIcons(); }
            }
        });
    }
})();
</script>
@endpush
