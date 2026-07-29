<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | InfiniTG</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="authwrap">

    <!-- Left Side -->
    <div class="left">
        <div>
            <h1>∞ InfiniTG</h1>

            <p style="margin-top:20px;">
                Unlimited cloud storage powered by Telegram.
            </p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="right">

        <div class="box">

            <h2>Create Account</h2>

            @if ($errors->any())
                <div style="color:red; margin-bottom:15px;">
                    <ul style="padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">

                @csrf

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Full Name"
                    required
                    autofocus
                >

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email Address"
                    required
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required
                >

                <button type="submit">
                    Create Account
                </button>

            </form>

            <p style="margin-top:20px; text-align:center;">
                Already have an account?
                <a href="{{ route('login') }}">
                    Login
                </a>
            </p>

        </div>

    </div>

</div>

</body>
</html>