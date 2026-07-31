@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<h1 style="margin-bottom:25px;">Settings</h1>

@if(session('success'))
<p style="color:green;margin-bottom:20px;">
    {{ session('success') }}
</p>
@endif

{{-- Profile --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">👤 Profile</h2>

    <table>
        <tr>
            <td><strong>Name</strong></td>
            <td>{{ $user->name }}</td>
        </tr>

        <tr>
            <td><strong>Email</strong></td>
            <td>{{ $user->email }}</td>
        </tr>
    </table>

</div>

{{-- Storage --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">💾 Storage Information</h2>

    <table>
        <tr>
            <td><strong>Total Files</strong></td>
            <td>{{ $totalFiles }}</td>
        </tr>

        <tr>
            <td><strong>Storage Used</strong></td>
            <td>{{ $storageUsed }} MB</td>
        </tr>

        <tr>
            <td><strong>Favorite Files</strong></td>
            <td>{{ $favoriteCount }}</td>
        </tr>

        <tr>
            <td><strong>Trash Files</strong></td>
            <td>{{ $trashCount }}</td>
        </tr>
    </table>

</div>

{{-- Telegram --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">📱 Telegram Account</h2>

    @csrf

    <label>Phone Number</label>

    <input
        type="text"
        id="phone"
        placeholder="+8801XXXXXXXXX"
        style="width:100%;padding:10px;margin:10px 0 15px;"
    >

    <button
        id="send-code-btn"
        class="btn"
        type="button"
    >
        Send Code
    </button>

    <hr style="margin:25px 0;">

    <label>Verification Code</label>

    <input
        type="text"
        id="telegram-code"
        placeholder="Enter Telegram OTP"
        style="width:100%;padding:10px;margin:10px 0 15px;"
    >

    <button
        id="verify-code-btn"
        class="btn"
        type="button"
    >
        Verify Code
    </button>

    <pre id="response" style="margin-top:20px;"></pre>

</div>

<script>

const csrf = "{{ csrf_token() }}";

document.getElementById('send-code-btn').addEventListener('click', async () => {

    const response = await fetch("{{ route('telegram.send-code') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrf
        },

        body: JSON.stringify({
            phone: document.getElementById('phone').value
        })

    });

    const data = await response.json();

    document.getElementById('response').textContent =
        JSON.stringify(data, null, 4);

});


document.getElementById('verify-code-btn').addEventListener('click', async () => {

    const response = await fetch("{{ route('telegram.verify-code') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrf
        },

        body: JSON.stringify({
            code: document.getElementById('telegram-code').value
        })

    });

    const data = await response.json();

    document.getElementById('response').textContent =
        JSON.stringify(data, null, 4);

});

</script>

{{-- Security --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">🔒 Security</h2>

    <p>Password is securely encrypted.</p>

    <br>

    <button class="btn" disabled>
        Change Password (Coming Soon)
    </button>

</div>

{{-- About --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">ℹ️ About</h2>

    <table>

        <tr>
            <td><strong>Application</strong></td>
            <td>InfiniTG</td>
        </tr>

        <tr>
            <td><strong>Version</strong></td>
            <td>v1.0 Beta</td>
        </tr>

        <tr>
            <td><strong>Framework</strong></td>
            <td>Laravel {{ app()->version() }}</td>
        </tr>

        <tr>
            <td><strong>PHP Version</strong></td>
            <td>{{ PHP_VERSION }}</td>
        </tr>

    </table>

</div>

@endsection