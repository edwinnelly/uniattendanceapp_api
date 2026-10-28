{{-- resources/views/admin/programs/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Program — DipTek Attendance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fluent: {
                            blue: '#0078D4',
                            darkBlue: '#106EBE',
                            lightBlue: '#D0E7F8',
                            bg: '#FAF9F8',
                            text: '#1B1A19',
                            secondary: '#605E5C',
                            border: '#EDEBE9',
                            success: '#107C10',
                            warning: '#FF8C00',
                            error: '#D13438',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #pageLoader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .btn-primary {
            background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%);
            border: 1px solid #106EBE;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%);
            box-shadow: 0 4px 10px rgba(0, 120, 212, 0.22);
        }

        .btn-primary:active { transform: scale(0.98); }

        .field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #EDEBE9;
            border-radius: 10px;
            font-size: 14px;
            color: #1B1A19;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field::placeholder { color: #A19F9D; }

        .field:focus {
            outline: none;
            border-color: #0078D4;
            box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.12);
        }

        .field.is-invalid {
            border-color: #D13438;
            box-shadow: 0 0 0 3px rgba(209, 52, 56, 0.08);
        }

        .label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1B1A19;
            margin-bottom: 6px;
        }

        .hint {
            font-size: 12px;
            color: #605E5C;
            margin-top: 6px;
        }

        .error-text {
            font-size: 12px;
            color: #D13438;
            margin-top: 6px;
        }

        /* Toggle (matches index) */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 20px;
            flex-shrink: 0;
        }

        .toggle-switch input { opacity: 0; width: 0; height: 0; }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background-color: #E5E7EB;
            transition: 0.25s;
            border-radius: 20px;
            cursor: pointer;
        }

        .toggle-slider:before {
            content: "";
            position: absolute;
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            transition: 0.25s;
            border-radius: 50%;
        }

        .toggle-switch input:checked + .toggle-slider { background-color: #107C10; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(18px); }

        @media (max-width: 1024px) {
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 89;
            }
            .sidebar-overlay.active { display: block; }
        }
    </style>
</head>

<body class="bg-fluent-bg font-sans antialiased">

    <div id="pageLoader"
        class="fixed inset-0 bg-white z-[999] flex items-center justify-center flex-col gap-4 transition-opacity duration-300">
        <img src="{{ asset('logo/logo.png') }}" alt="DipTek" class="w-10 h-10">
        <div class="text-xs text-gray-500">Loading…</div>
    </div>

    <button
        class="lg:hidden fixed top-3.5 left-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 flex items-center justify-center text-fluent-text shadow-lg"
        id="mobileToggle" aria-label="Toggle sidebar">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="5" cy="12" r="1.5" />
            <circle cx="12" cy="12" r="1.5" />
            <circle cx="19" cy="12" r="1.5" />
        </svg>
    </button>

    <button
        class="lg:hidden fixed top-3.5 right-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 flex items-center justify-center text-fluent-text shadow-lg"
        id="mobileRightToggle" aria-label="Toggle quick access">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="9" />
            <polyline points="12 7 12 12 15 14" />
        </svg>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div
        class="grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">

        @include('inc.sidebar')

        <main class="p-6 lg:p-7 overflow-y-auto h-screen">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2 text-sm">
                        <a href="{{ route('programs.index') }}"
                            class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-fluent-secondary">Programs</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="font-semibold text-fluent-text">New</span>
                    </div>
                    <h1 class="text-2xl font-bold text-fluent-text tracking-tight">New Program</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Add a program to the faculty catalogue.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-2.5 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 text-sm">
                    <div class="font-semibold mb-1">Please fix the following:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-fluent-border max-w-2xl">
                <div class="px-6 py-4 border-b border-fluent-border">
                    <h2 class="text-sm font-semibold text-fluent-text">Program details</h2>
                </div>

                <form action="{{ route('programs.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="label">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="field @error('name') is-invalid @enderror"
                            placeholder="e.g. Computer Science" required autofocus>
                        @error('name')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="code" class="label">Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}"
                            class="field @error('code') is-invalid @enderror" placeholder="e.g. CSC"
                            maxlength="20" required>
                        <p class="hint">Short, unique. Up to 20 characters.</p>
                        @error('code')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="label">Description <span class="text-fluent-secondary font-normal">(optional)</span></label>
                        <textarea id="description" name="description" rows="4"
                            class="field @error('description') is-invalid @enderror"
                            placeholder="A short summary of what this program covers.">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 flex items-center justify-between py-3 px-4 bg-fluent-bg rounded-lg border border-fluent-border">
                        <div>
                            <div class="text-sm font-semibold text-fluent-text">Active</div>
                            <div class="text-xs text-fluent-secondary mt-0.5">Inactive programs are hidden from enrolment.</div>
                        </div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-fluent-border mt-2">
                        <button type="submit"
                            class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 text-white rounded-lg text-sm font-semibold mt-4">
                            Save Program
                        </button>
                        <a href="{{ route('programs.index') }}"
                            class="inline-flex items-center px-5 py-2.5 text-fluent-secondary bg-white border border-fluent-border rounded-lg text-sm font-semibold hover:bg-fluent-bg mt-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>

        @include('inc.quick_access')
    </div>

    <script>
        setTimeout(() => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(() => loader.remove(), 200);
            }
        }, 200);

        const overlay = document.getElementById('sidebarOverlay');
        const sidebarLeft = document.getElementById('sidebarLeft');
        const sidebarRight = document.getElementById('sidebarRight');

        function closeAll() {
            sidebarLeft?.classList.remove('open');
            sidebarRight?.classList.remove('open');
            overlay?.classList.remove('active');
            if (overlay) overlay.style.display = 'none';
        }

        function open(sidebar) {
            closeAll();
            if (!sidebar) return;
            sidebar.classList.add('open');
            if (overlay) {
                overlay.style.display = 'block';
                requestAnimationFrame(() => overlay.classList.add('active'));
            }
        }

        document.getElementById('mobileToggle')?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarLeft?.classList.contains('open') ? closeAll() : open(sidebarLeft);
        });

        document.getElementById('mobileRightToggle')?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarRight?.classList.contains('open') ? closeAll() : open(sidebarRight);
        });

        overlay?.addEventListener('click', closeAll);
    </script>
</body>

</html>