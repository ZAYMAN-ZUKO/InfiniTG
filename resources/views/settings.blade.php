@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<h1 style="margin-bottom:25px;">Settings</h1>

@if(session('success'))
    <p style="color:green; margin-bottom:20px;">
        {{ session('success') }}
    </p>
@endif

{{-- Profile --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">👤 Profile</h2>

    <table>
        <tbody>

            <tr>
                <td><strong>Name</strong></td>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>

        </tbody>
    </table>

</div>

{{-- Storage --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">💾 Storage Information</h2>

    <table>
        <tbody>

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

        </tbody>
    </table>

</div>

{{-- Telegram --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">🤖 Telegram Integration</h2>

    <table>
        <tbody>

            <tr>
                <td><strong>Status</strong></td>
                <td>
                    <span style="color:red;">
                        ● Not Connected
                    </span>
                </td>
            </tr>

            <tr>
                <td><strong>Bot</strong></td>
                <td>Not Configured</td>
            </tr>

            <tr>
                <td><strong>Channel</strong></td>
                <td>Not Configured</td>
            </tr>

        </tbody>
    </table>

</div>

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
        <tbody>

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

        </tbody>
    </table>

</div>

@endsection