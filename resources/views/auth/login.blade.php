
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DipTek — Sign in</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#171A19',
                        body: '#5F6763',
                        muted: '#89918D',
                        border: '#E4E8E5',
                        surface: '#FFFFFF',
                        background: '#F6F7F5',
                        green: '#176B58',
                        'green-dark': '#115443',
                        'green-soft': '#EEF6F3',
                        danger: '#B54736',
                    },

                    fontFamily: {
                        sans: ['"DM Sans"', 'sans-serif'],
                        display: ['"Manrope"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            background: #F6F7F5;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                linear-gradient(
                    180deg,
                    #F8F9F7 0%,
                    #F5F6F4 100%
                );
            color: #171A19;
            font-family: "DM Sans", sans-serif;
        }

        ::selection {
            background: #176B58;
            color: #fff;
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .shell {
            width: 100%;
            max-width: 430px;
        }

        .login-card {
            background: rgba(255, 255, 255, .94);
            border: 1px solid #E4E8E5;
            border-radius: 18px;
            padding: 38px;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, .02),
                0 12px 35px rgba(18, 30, 25, .055);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 38px;
        }

        .brand-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            object-fit: cover;
            display: block;
        }

        .logo-fallback {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: #176B58;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Manrope", sans-serif;
            font-weight: 800;
            font-size: 17px;
        }

        .brand-name {
            font-family: "Manrope", sans-serif;
            font-size: 17px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .brand-caption {
            margin-top: 5px;
            color: #89918D;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .02em;
        }

        .secure-mark {
            width: 34px;
            height: 34px;
            border: 1px solid #E4E8E5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #176B58;
            background: #FAFCFB;
        }

        .heading {
            margin-bottom: 30px;
        }

        .eyebrow {
            color: #176B58;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: 10px;
        }

        .title {
            margin: 0;
            font-family: "Manrope", sans-serif;
            font-size: 29px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -.045em;
            color: #171A19;
        }

        .subtitle {
            margin: 9px 0 0;
            color: #69716D;
            font-size: 14px;
            line-height: 1.6;
        }

        .message {
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.5;
        }

        .message-success {
            color: #176B58;
            background: #EEF6F3;
            border: 1px solid #D8EBE5;
        }

        .message-error {
            color: #A43F31;
            background: #FEF4F2;
            border: 1px solid #F2D8D3;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 21px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .label {
            color: #343B38;
            font-size: 12px;
            font-weight: 600;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9AA29E;
            pointer-events: none;
            transition: color .18s ease;
        }

        .input {
            width: 100%;
            height: 48px;
            padding: 0 14px 0 43px;
            border: 1px solid #DDE2DF;
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: #171A19;
            font-family: "DM Sans", sans-serif;
            font-size: 14px;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .input::placeholder {
            color: #A4AAA7;
        }

        .input:hover {
            border-color: #C9D0CC;
        }

        .input:focus {
            border-color: #176B58;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(23, 107, 88, .09);
        }

        .input-wrap:focus-within .input-icon {
            color: #176B58;
        }

        .error-text {
            color: #B54736;
            font-size: 12px;
            line-height: 1.4;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -3px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #69716D;
            font-size: 13px;
            cursor: pointer;
        }

        .checkbox {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #176B58;
            cursor: pointer;
        }

        .forgot {
            color: #176B58;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot:hover {
            color: #115443;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .submit {
            width: 100%;
            height: 49px;
            border: 0;
            border-radius: 10px;
            background: #176B58;
            color: #fff;
            font-family: "DM Sans", sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(23, 107, 88, .16);
            transition:
                background .18s ease,
                transform .15s ease,
                box-shadow .18s ease;
        }

        .submit:hover {
            background: #115443;
            box-shadow: 0 7px 18px rgba(23, 107, 88, .20);
            transform: translateY(-1px);
        }

        .submit:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(23, 107, 88, .14);
        }

        .submit:disabled {
            background: #A8B8B2;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            color: #7C8581;
            font-size: 12px;
            line-height: 1.6;
        }

        .footer a {
            color: #176B58;
            font-weight: 600;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .legal {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 14px;
            color: #A1A8A5;
            font-size: 11px;
        }

        .legal span:not(:first-child)::before {
            content: "•";
            margin-right: 10px;
        }

        .copyright {
            text-align: center;
            margin-top: 18px;
            color: #A1A8A5;
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .page {
                padding: 18px 14px;
                align-items: flex-start;
                padding-top: 28px;
            }

            .login-card {
                padding: 28px 22px;
                border-radius: 15px;
            }

            .brand {
                margin-bottom: 32px;
            }

            .title {
                font-size: 26px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <main class="shell">

        <section class="login-card" aria-label="DipTek sign in">

            {{-- Brand --}}
            <div class="brand">

                <div class="brand-left">

                    @if(file_exists(public_path('logo/logo.png')))
                        <img
                            src="{{ asset('logo/logo.png') }}"
                            alt="DipTek"
                            class="logo"
                            width="42"
                            height="42"
                        >
                    @else
                        <div class="logo-fallback" aria-hidden="true">
                            D
                        </div>
                    @endif

                    <div>
                        <div class="brand-name">
                            DipTek
                        </div>

                        <div class="brand-caption">
                            School Portal
                        </div>
                    </div>

                </div>

                <div class="secure-mark" title="Secure connection" aria-label="Secure connection">
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <rect x="4" y="10" width="16" height="10" rx="2"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                </div>

            </div>


            {{-- Heading --}}
            <div class="heading">

                <div class="eyebrow">
                    Account access
                </div>

                <h1 class="title">
                    Sign in to your account
                </h1>

                <p class="subtitle">
                    Enter your details to continue to the DipTek portal.
                </p>

            </div>


            {{-- Status --}}
            @if (session('status'))
                <div class="message message-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="message message-error" role="alert">

                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                </div>
            @endif


            {{-- Login --}}
            <form
                method="POST"
                action="{{ route('login') }}"
                class="form"
                id="loginForm"
                novalidate
            >

                @csrf


                {{-- Email --}}
                <div class="field">

                    <label for="email" class="label">
                        Email address
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="input-icon"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="m3 7 9 6 9-6"/>
                        </svg>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="input"
                            placeholder="name@example.com"
                            aria-describedby="email-error"
                        >

                    </div>

                    @error('email')
                        <p id="email-error" class="error-text">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="field">

                    <label for="password" class="label">
                        Password
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="input-icon"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect x="4" y="10" width="16" height="10" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        </svg>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="input"
                            placeholder="Enter your password"
                            aria-describedby="password-error"
                        >

                    </div>

                    @error('password')
                        <p id="password-error" class="error-text">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Options --}}
                <div class="form-options">

                    <label for="remember_me" class="remember">

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="checkbox"
                        >

                        <span>
                            Remember me
                        </span>

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot"
                        >
                            Forgot password?
                        </a>

                    @endif

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="submit"
                    id="submitBtn"
                >
                    <span id="submitLabel">
                        Sign in
                    </span>
                </button>

            </form>

        </section>


        {{-- Footer --}}
        <div class="footer">

            <div>
                New to DipTek?
                <a href="{{ route('register') }}">
                    Create an account
                </a>
            </div>

            <div class="legal">
                <span>Privacy</span>
                <span>Terms</span>
                <span>Secure access</span>
            </div>

            <div class="copyright">
                &copy; {{ date('Y') }} DipTek
            </div>

        </div>

    </main>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('loginForm');
        const button = document.getElementById('submitBtn');
        const label = document.getElementById('submitLabel');
        const email = document.getElementById('email');

        if (form && button && label) {

            form.addEventListener('submit', function () {

                button.disabled = true;
                label.textContent = 'Signing in…';

            });

        }

        if (email && window.innerWidth < 768) {

            setTimeout(function () {
                email.focus();
            }, 300);

        }

    });
</script>

</body>
</html>

