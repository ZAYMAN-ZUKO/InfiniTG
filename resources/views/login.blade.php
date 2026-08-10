<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | InfiniTG</title>

    <link rel="stylesheet" href="/css/style.css">
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

            <h2>Welcome Back</h2>

            @if (session('status'))
                <p style="color:green; margin-bottom:15px;">
                    {{ session('status') }}
                </p>
            @endif

            @if ($errors->any())
                <div style="color:red; margin-bottom:15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email Address"
                    required
                    autofocus
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >

                <button type="submit">
                    Sign In
                </button>

            </form>

            <p style="margin-top:20px; text-align:center;">
                Don't have an account?
                <a href="{{ route('register') }}">
                    Register
                </a>
            </p>

            <p style="margin-top:10px; text-align:center;">
                <a href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            </p>

        </div>

    </div>

</div>

</body>
</html>