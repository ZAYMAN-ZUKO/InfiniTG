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
                <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}</td>
            </tr>
        </table>
    </div>

    {{-- Storage --}}
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="hard-drive" aria-hidden="true"></i> Storage Information</h3>
        </div>

        @php
            $usedMB = $storageUsed ?? 0;
            $maxMB = config('infinitg.max_storage_mb');
            $percent = min(round(($usedMB / $maxMB) * 100, 2), 100);
        @endphp

        <div class="meter">
            <div class="meter-fill" style="width:{{ $percent }}%"></div>
        </div>
        <div class="meter-meta">
            <b>{{ $usedMB }} MB used</b>
            <span>{{ $maxMB }} MB free plan</span>
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
    <div class="panel">
        <div class="panel-head">
            <h3><i data-lucide="send" aria-hidden="true"></i> Telegram Account</h3>
            @if($telegramConnected)
                <span class="badge badge-success"><i data-lucide="check" aria-hidden="true"></i>Connected</span>
            @else
                <span class="badge badge-warn"><i data-lucide="alert-circle" aria-hidden="true"></i>Not Connected</span>
            @endif
        </div>

        @if($telegramConnected)
            {{-- Connected state --}}
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
                    <td>{{ $telegramPhone ?? '—' }}</td>
                </tr>
                <tr>
                    <td>Connected On</td>
                    <td>{{ $telegramConnectedAt ? $telegramConnectedAt->format('d M Y') : '—' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>
            </table>

            <div style="margin-top:16px">
                <button class="btn btn-ghost btn-block" type="button" onclick="return confirm('Disconnect your Telegram account? You will need to reconnect to continue using Telegram storage.')">
                    <i data-lucide="unplug" aria-hidden="true"></i>Disconnect Telegram
                </button>
            </div>

        @else
            {{-- Not connected state --}}
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
        @endif
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

    if (!responseBox) { return; }

    function setStatus(data, ok) {
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
            body: JSON.stringify(payload)
        });
        return res.json();
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
        });
    }
})();
</script>
@endpush