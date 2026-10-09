
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DipTek — Create Account</title>

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
            background: linear-gradient(
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
            max-width: 460px;
        }

        .card {
            background: rgba(255, 255, 255, .96);
            border: 1px solid #E4E8E5;
            border-radius: 18px;
            padding: 38px;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, .02),
                0 14px 40px rgba(18, 30, 25, .055);
        }

        /* ---------------------------------------------------------
           BRAND
        --------------------------------------------------------- */

        .brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 34px;
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

        /* ---------------------------------------------------------
           HEADING
        --------------------------------------------------------- */

        .heading {
            margin-bottom: 28px;
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

        /* ---------------------------------------------------------
           ALERTS
        --------------------------------------------------------- */

        .error-box {
            border: 1px solid #F1D8D3;
            background: #FEF5F3;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
        }

        .error-text {
            color: #B54736;
            font-size: 12px;
            line-height: 1.5;
        }

        /* ---------------------------------------------------------
           FORM
        --------------------------------------------------------- */

        .form {
            display: flex;
            flex-direction: column;
            gap: 19px;
        }

        .field-group {
            position: relative;
        }

        .label {
            display: block;
            color: #343B38;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9AA29E;
            pointer-events: none;
            transition: color .18s ease;
        }

        .field {
            width: 100%;
            height: 48px;
            border: 1px solid #DDE2DF;
            border-radius: 10px;
            background: #FFFFFF;
            color: #171A19;
            outline: none;

            padding: 0 14px 0 43px;

            font-family: "DM Sans", sans-serif;
            font-size: 14px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .field::placeholder {
            color: #A4AAA7;
        }

        .field:hover {
            border-color: #C9D0CC;
        }

        .field:focus {
            border-color: #176B58;
            box-shadow: 0 0 0 3px rgba(23, 107, 88, .09);
        }

        .field-group:focus-within .field-icon {
            color: #176B58;
        }

        /* ---------------------------------------------------------
           PASSWORD STRENGTH
        --------------------------------------------------------- */

        .password-strength {
            height: 3px;
            width: 100%;
            background: #E8ECE9;
            border-radius: 999px;
            overflow: hidden;
            margin-top: 8px;
        }

        .password-strength-bar {
            width: 0%;
            height: 100%;
            border-radius: inherit;
            transition:
                width .25s ease,
                background-color .25s ease;
        }

        #strengthText {
            font-size: 11px;
            line-height: 1;
            margin-top: 7px;
            display: block;
        }

        /* ---------------------------------------------------------
           BUTTON
        --------------------------------------------------------- */

        .btn-primary {
            width: 100%;
            height: 49px;
            margin-top: 3px;

            border: 0;
            border-radius: 10px;

            background: #176B58;
            color: #FFFFFF;

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

        .btn-primary:hover {
            background: #115443;
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(23, 107, 88, .20);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(23, 107, 88, .14);
        }

        .btn-primary:disabled {
            background: #A8B8B2;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        /* ---------------------------------------------------------
           FOOTER
        --------------------------------------------------------- */

        .footer {
            text-align: center;
            margin-top: 24px;
            color: #7C8581;
            font-size: 13px;
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
            margin-top: 17px;
            color: #A1A8A5;
            font-size: 11px;
        }

        /* ---------------------------------------------------------
           MOBILE
        --------------------------------------------------------- */

        @media (max-width: 520px) {

            .page {
                align-items: flex-start;
                padding: 24px 14px;
            }

            .card {
                padding: 28px 21px;
                border-radius: 15px;
            }

            .brand {
                margin-bottom: 30px;
            }

            .title {
                font-size: 26px;
            }

            .subtitle {
                font-size: 13px;
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

        <section class="card" role="main" aria-label="Create DipTek account">

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
                            Student Portal
                        </div>

                    </div>

                </div>


                <div
                    class="secure-mark"
                    title="Secure registration"
                    aria-label="Secure registration"
                >

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
                    Account registration
                </div>

                <h1 class="title">
                    Create your account
                </h1>

                <p class="subtitle">
                    Set up your DipTek portal account to get started.
                </p>

            </div>


            {{-- Errors --}}
            @if ($errors->any())

                <div class="error-box" role="alert">

                    @foreach ($errors->all() as $error)

                        <p class="error-text">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif


            {{-- Register Form --}}
            <form
                method="POST"
                action="{{ route('register') }}"
                class="form"
                id="registerForm"
                novalidate
            >

                @csrf


                {{-- Full Name --}}
                <div class="field-group">

                    <label
                        for="name"
                        class="label"
                    >
                        Full name
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="field-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.2-6 8-6s8 2 8 6"/>
                        </svg>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="field"
                            placeholder="John Doe"
                            aria-describedby="name-error"
                        >

                    </div>

                    @error('name')

                        <p
                            id="name-error"
                            class="error-text"
                            style="margin-top: 6px;"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Email --}}
                <div class="field-group">

                    <label
                        for="email"
                        class="label"
                    >
                        Email address
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="field-icon"
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
                            autocomplete="username"
                            class="field"
                            placeholder="name@example.com"
                            aria-describedby="email-error"
                        >

                    </div>

                    @error('email')

                        <p
                            id="email-error"
                            class="error-text"
                            style="margin-top: 6px;"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Password --}}
                <div class="field-group">

                    <label
                        for="password"
                        class="label"
                    >
                        Password
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="field-icon"
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
                            autocomplete="new-password"
                            class="field"
                            placeholder="Create a password"
                            aria-describedby="password-error"
                            oninput="checkPasswordStrength(this.value)"
                        >

                    </div>

                    <div
                        class="password-strength"
                        id="strengthMeter"
                        aria-hidden="true"
                    >
                        <div
                            class="password-strength-bar"
                            id="strengthBar"
                        ></div>
                    </div>

                    @error('password')

                        <p
                            id="password-error"
                            class="error-text"
                            style="margin-top: 6px;"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Confirm Password --}}
                <div class="field-group">

                    <label
                        for="password_confirmation"
                        class="label"
                    >
                        Confirm password
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="field-icon"
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
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="field"
                            placeholder="Repeat your password"
                            aria-describedby="password-confirmation-error"
                        >

                    </div>

                    @error('password_confirmation')

                        <p
                            id="password-confirmation-error"
                            class="error-text"
                            style="margin-top: 6px;"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="btn-primary"
                    id="submitBtn"
                >
                    <span id="submitLabel">
                        Create account
                    </span>
                </button>

            </form>

        </section>


        {{-- Footer --}}
        <footer class="footer">

            <div>
                Already have an account?

                <a href="{{ route('login') }}">
                    Sign in
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

        </footer>

    </main>

</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('registerForm');
        const btn = document.getElementById('submitBtn');
        const label = document.getElementById('submitLabel');
        const nameInput = document.getElementById('name');

        if (form && btn && label) {

            form.addEventListener('submit', function () {

                btn.disabled = true;
                label.textContent = 'Creating account…';

            });

        }

        if (nameInput && window.innerWidth < 768) {

            setTimeout(function () {
                nameInput.focus();
            }, 300);

        }

    });


    function checkPasswordStrength(password) {

        const bar = document.getElementById('strengthBar');

        if (!bar) return;

        let strength = 0;

        if (password.length >= 8) {
            strength++;
        }

        if (password.match(/[a-z]+/)) {
            strength++;
        }

        if (password.match(/[A-Z]+/)) {
            strength++;
        }

        if (password.match(/[0-9]+/)) {
            strength++;
        }

        if (password.match(/[$@#&!]+/)) {
            strength++;
        }

        const percentage = (strength / 5) * 100;

        let background = '#DDE2DF';

        if (strength <= 1) {
            background = '#B54736';
        } else if (strength === 2) {
            background = '#B7791F';
        } else if (strength === 3) {
            background = '#176B58';
        } else if (strength >= 4) {
            background = '#176B58';
        }

        bar.style.width = percentage + '%';
        bar.style.backgroundColor = background;

    }

</script>


{{-- Preload critical asset --}}
<link
    rel="preload"
    href="{{ asset('logo/logo.png') }}"
    as="image"
    type="image/png"
    crossorigin="anonymous"
>

</body>
</html>

