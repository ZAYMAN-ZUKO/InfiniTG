<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InfiniTG') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
</head>
<body>

<div class="auth-wrap">

    <aside class="auth-side">
        <a href="{{ route('home') }}" class="auth-brand">
            <span class="auth-brand-mark"><i data-lucide="infinity" aria-hidden="true"></i></span>
            InfiniTG
        </a>

        <div class="auth-copy">
            <h1>Your files, stored infinitely.</h1>
            <p class="auth-sub">
                Sign in to access your unlimited cloud storage, powered by Telegram infrastructure.
            </p>
        </div>

        <div class="auth-points">
            <div class="auth-point">
                <span class="auth-point-icon"><i data-lucide="infinity" aria-hidden="true"></i></span>
                <div>
                    <b>Unlimited storage</b>
                    <p>Upload as much as you want, worry-free.</p>
                </div>
            </div>
            <div class="auth-point">
                <span class="auth-point-icon"><i data-lucide="zap" aria-hidden="true"></i></span>
                <div>
                    <b>Lightning fast</b>
                    <p>Upload and download at Telegram speeds.</p>
                </div>
            </div>
            <div class="auth-point">
                <span class="auth-point-icon"><i data-lucide="shield-check" aria-hidden="true"></i></span>
                <div>
                    <b>Secure &amp; reliable</b>
                    <p>Your files are safe, private and always accessible.</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="auth-main">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </main>

</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>if (window.lucide) { lucide.createIcons(); }</script>

</body>
</html>
