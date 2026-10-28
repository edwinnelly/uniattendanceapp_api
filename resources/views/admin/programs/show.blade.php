{{-- resources/views/admin/programs/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->name }} — DipTek Attendance</title>

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

        .modal-overlay { animation: fadeIn 0.2s ease-out; }
        .modal-content { animation: slideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1); }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

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

            <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-6 gap-4">
                <div class="min-w-0">
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
                        <span class="font-semibold text-fluent-text">{{ $program->code }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-fluent-text tracking-tight truncate">{{ $program->name }}</h1>
                    <div class="flex items-center gap-2 mt-1.5">
                        @if ($program->is_active)
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-fluent-success">
                                <span class="w-1.5 h-1.5 bg-fluent-success rounded-full"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-fluent-secondary">
                                <span class="w-1.5 h-1.5 bg-fluent-secondary rounded-full"></span>
                                Inactive
                            </span>
                        @endif
                        <span class="text-fluent-secondary text-xs">·</span>
                        <span class="text-xs text-fluent-secondary">Updated {{ $program->updated_at?->diffForHumans() ?? '—' }}</span>
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('programs.edit', encrypt($program->id)) }}"
                        class="btn-primary inline-flex items-center gap-2 px-4 py-2.5 text-white rounded-lg text-sm font-semibold">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('programs.index') }}"
                        class="inline-flex items-center px-4 py-2.5 text-fluent-secondary bg-white border border-fluent-border rounded-lg text-sm font-semibold hover:bg-fluent-bg">
                        Back
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-fluent-border max-w-3xl mb-6">
                <div class="px-6 py-4 border-b border-fluent-border">
                    <h2 class="text-sm font-semibold text-fluent-text">Details</h2>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 p-6">
                    <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Name</dt>
                        <dd class="text-sm text-fluent-text mt-1">{{ $program->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Code</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-0.5 bg-fluent-lightBlue text-fluent-blue rounded text-xs font-semibold">
                                {{ $program->code }}
                            </span>
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Description</dt>
                        <dd class="text-sm text-fluent-text mt-1 leading-relaxed">
                            {{ $program->description ?: 'No description provided.' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Status</dt>
                        <dd class="text-sm text-fluent-text mt-1">
                            {{ $program->is_active ? 'Active' : 'Inactive' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Created</dt>
                        <dd class="text-sm text-fluent-text mt-1">
                            {{ $program->created_at?->format('M j, Y') ?? '—' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">Last updated</dt>
                        <dd class="text-sm text-fluent-text mt-1">
                            {{ $program->updated_at?->format('M j, Y') ?? '—' }}
                        </dd>
                    </div>

                    {{-- <div>
                        <dt class="text-xs font-semibold text-fluent-secondary uppercase tracking-wide">ID</dt>
                        <dd class="text-sm text-fluent-text mt-1 font-mono">#{{ $program->id }}</dd>
                    </div> --}}
                </dl>
            </div>

            <div class="bg-white rounded-xl border border-red-200 max-w-3xl">
                <div class="px-6 py-4 border-b border-red-100">
                    <h2 class="text-sm font-semibold text-fluent-error">Danger zone</h2>
                </div>
                <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-sm text-fluent-secondary">
                        Deleting this program is permanent and cannot be undone.
                    </p>
                    <button type="button" onclick="openDeleteModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-fluent-error text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors shrink-0">
                        Delete program
                    </button>
                </div>
            </div>
        </main>

        @include('inc.quick_access')
    </div>

    <div id="deleteModal" class="fixed inset-0 z-[200] hidden">
        <div class="modal-overlay absolute inset-0 bg-black/40" onclick="closeDeleteModal()"></div>

        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="modal-content bg-white rounded-xl shadow-2xl max-w-sm w-full p-5">
                <h2 class="text-base font-bold text-fluent-text">Delete this program?</h2>
                <p class="text-sm text-fluent-secondary mt-2">
                    <span class="font-semibold text-fluent-text">{{ $program->name }}</span>
                    will be permanently removed. This cannot be undone.
                </p>

                <div class="flex gap-2 mt-5">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 text-sm font-medium text-fluent-secondary bg-fluent-bg border border-fluent-border rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <form action="{{ route('programs.destroy', encrypt($program->id)) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-semibold text-white bg-fluent-error rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(() => loader.remove(), 200);
            }
        }, 200);

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteModal();
        });

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