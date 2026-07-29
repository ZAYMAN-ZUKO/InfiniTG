<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfiniTG | Unlimited Cloud Storage</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="center">

        <!-- Navigation -->
        <nav style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">

            <div class="logo">
                ∞ InfiniTG
            </div>

            <div>
                <a href="{{ route('login') }}">Login</a>

                <a href="{{ route('register') }}" class="btn" style="margin-left:15px;">
                    Get Started
                </a>
            </div>

        </nav>

        <!-- Hero Section -->
        <section class="hero">

            <h1>Unlimited Cloud Storage</h1>

            <p>
                Powered by Telegram Infrastructure.
                Store, organize and access your files
                with a modern, fast and secure cloud experience.
            </p>

            <a href="{{ route('register') }}" class="btn">
                Start Free
            </a>

        </section>

        <!-- Features -->
        <section class="features">

            <div class="card">
                <h3>Unlimited Storage</h3>

                <p>
                    Store unlimited files using Telegram cloud infrastructure.
                </p>
            </div>

            <div class="card">
                <h3>Lightning Fast</h3>

                <p>
                    Quickly upload, organize and access your files anytime.
                </p>
            </div>

            <div class="card">
                <h3>Secure & Reliable</h3>

                <p>
                    Keep your files protected with a clean and secure platform.
                </p>
            </div>

        </section>

        <!-- CTA -->
        <section class="panel" style="text-align:center; margin-top:50px;">

            <h2>Ready to get started?</h2>

            <p style="margin:15px 0;">
                Create your free account and start managing your files today.
            </p>

            <a href="{{ route('register') }}" class="btn">
                Create Free Account
            </a>

        </section>

    </div>

</body>
</html>