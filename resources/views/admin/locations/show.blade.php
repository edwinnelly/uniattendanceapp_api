{{-- resources/views/admin/lecture-locations/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lectureLocation->name }} — DipTek Attendance</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
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
                        sidebar: {
                            bg: '#0a0e17',
                            text: '#e2e8f0',
                            muted: '#94a3b8',
                            label: '#64748b',
                            border: 'rgba(255, 255, 255, 0.06)',
                            hover: 'rgba(255, 255, 255, 0.04)',
                        }
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

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .btn-sleek {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-sleek:active {
            transform: scale(0.97);
        }

        .btn-sleek-primary {
            background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%);
            border: 1px solid #106EBE;
        }

        .btn-sleek-primary:hover {
            background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%);
            box-shadow: 0 4px 8px rgba(0, 120, 212, 0.25);
        }

        .btn-sleek-danger {
            background: linear-gradient(180deg, #D13438 0%, #B82D31 100%);
            border: 1px solid #B82D31;
        }

        .btn-sleek-danger:hover {
            background: linear-gradient(180deg, #B82D31 0%, #A0282C 100%);
            box-shadow: 0 4px 8px rgba(209, 52, 56, 0.25);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-badge-active {
            background: rgba(16, 124, 16, 0.1);
            color: #107C10;
        }

        .status-badge-inactive {
            background: rgba(209, 52, 56, 0.1);
            color: #D13438;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot-active {
            background: #107C10;
        }

        .status-dot-inactive {
            background: #D13438;
        }

        /* Simple Modal */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        @media (max-width: 1024px) {
            .sidebar-left {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                width: 280px !important;
                z-index: 90;
                transform: translateX(-100%);
                transition: transform 0.3s;
                visibility: hidden;
            }

            .sidebar-left.open {
                transform: translateX(0);
                visibility: visible;
            }

            .sidebar-right {
                position: fixed;
                right: 0;
                top: 0;
                bottom: 0;
                width: 320px !important;
                z-index: 90;
                transform: translateX(100%);
                transition: transform 0.3s;
                visibility: hidden;
            }

            .sidebar-right.open {
                transform: translateX(0);
                visibility: visible;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 89;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-fluent-bg font-sans antialiased">

    <!-- Page Loader -->
    <div id="pageLoader"
        class="fixed inset-0 bg-white z-[999] flex items-center justify-center flex-col gap-5 transition-opacity duration-300">
        <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
            <img src="{{ asset('logo/logo.png') }}" alt="DipTek Logo" class="w-8 h-8">
        </div>
        <div class="text-center">
            <div class="font-bold text-lg text-gray-800 uppercase tracking-wider">DipTek</div>
            <div class="text-xs text-gray-500 mt-1">Loading...</div>
        </div>
    </div>

    <!-- Mobile Toggles -->
    <button
        class="lg:hidden fixed top-3.5 left-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 cursor-pointer flex items-center justify-center text-fluent-text shadow-lg"
        id="mobileToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="5" cy="12" r="1.5" />
            <circle cx="12" cy="12" r="1.5" />
            <circle cx="19" cy="12" r="1.5" />
        </svg>
    </button>

    <button
        class="lg:hidden fixed top-3.5 right-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 cursor-pointer flex items-center justify-center text-fluent-text shadow-lg"
        id="mobileRightToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="9" />
            <polyline points="12 7 12 12 15 14" />
        </svg>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div
        class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">

        <!-- Left Sidebar -->
        @include('inc.sidebar')

        <!-- Main Content -->
        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('lecture-locations.index') }}"
                            class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Lecture Locations</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">{{ $lectureLocation->code }}</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">{{ $lectureLocation->name }}</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Location Details</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('lecture-locations.edit', encrypt($lectureLocation->id)) }}"
                        class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                    <button onclick="openDeleteModal()"
                        class="btn-sleek btn-sleek-danger inline-flex items-center justify-center gap-2 px-5 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Delete
                    </button>
                    <a href="{{ route('lecture-locations.index') }}"
                        class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                        Back
                    </a>
                </div>
            </div>

            <!-- Location Details Card -->
            <div class="bg-white rounded-2xl shadow-card border border-fluent-border p-6 lg:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Location Name</p>
                        <p class="text-lg font-semibold text-fluent-text">{{ $lectureLocation->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Location Code</p>
                        <span
                            class="px-3 py-1 bg-fluent-lightBlue text-fluent-blue rounded-lg text-sm font-bold">{{ $lectureLocation->code }}</span>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Building</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            {{ $lectureLocation->building ?? 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Floor / Room</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            @if($lectureLocation->floor && $lectureLocation->room_number)
                                Floor {{ $lectureLocation->floor }}, Room {{ $lectureLocation->room_number }}
                            @elseif($lectureLocation->floor)
                                Floor {{ $lectureLocation->floor }}
                            @elseif($lectureLocation->room_number)
                                Room {{ $lectureLocation->room_number }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Status</p>
                        @if ($lectureLocation->is_active)
                            <span class="status-badge status-badge-active">
                                <span class="status-dot status-dot-active"></span>Active
                            </span>
                        @else
                            <span class="status-badge status-badge-inactive">
                                <span class="status-dot status-dot-inactive"></span>Inactive
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Capacity</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            @if($lectureLocation->capacity)
                                {{ $lectureLocation->capacity }} seats
                            @else
                                <span class="text-fluent-secondary">Unlimited</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Radius</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            {{ $lectureLocation->radius_meters }} meters
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Coordinates</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-medium text-fluent-text">
                                {{ number_format($lectureLocation->latitude, 6) }},
                                {{ number_format($lectureLocation->longitude, 6) }}
                            </p>
                            <a href="https://www.google.com/maps?q={{ $lectureLocation->latitude }},{{ $lectureLocation->longitude }}" 
                               target="_blank" 
                               class="text-fluent-blue hover:text-fluent-darkBlue text-sm">
                                View on Maps →
                            </a>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Full Address</p>
                        <p class="text-sm text-fluent-text">
                            {{ $lectureLocation->building ? $lectureLocation->building . ', ' : '' }}
                            {{ $lectureLocation->floor ? 'Floor ' . $lectureLocation->floor . ', ' : '' }}
                            {{ $lectureLocation->room_number ? 'Room ' . $lectureLocation->room_number : '' }}
                            {{ !$lectureLocation->building && !$lectureLocation->floor && !$lectureLocation->room_number ? 'No address specified' : '' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Created At</p>
                        <p class="text-sm text-fluent-text">{{ $lectureLocation->created_at->format('F j, Y g:i A') }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Last Updated</p>
                        <p class="text-sm text-fluent-text">{{ $lectureLocation->updated_at->format('F j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="mt-6 bg-white border border-red-200 rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-fluent-text">⚠️ Danger Zone</h3>
                        <p class="text-sm text-fluent-secondary mt-1">
                            Permanently delete this location. This action cannot be undone.
                        </p>
                    </div>
                    <button onclick="openDeleteModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl text-sm font-semibold hover:bg-red-600 transition-all whitespace-nowrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Delete Location
                    </button>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        @include('inc.quick_access')
    </div>

    <!-- Simple Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[200] hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeDeleteModal()"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#D13438" stroke-width="2">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <line x1="10" y1="11" x2="10" y2="17"/>
                            <line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h3 class="text-xl font-bold text-center text-fluent-text mb-2">Delete Location?</h3>
                
                <!-- Message -->
                <p class="text-sm text-center text-fluent-secondary mb-6">
                    Are you sure you want to delete <strong class="text-fluent-text">{{ $lectureLocation->name }}</strong>?
                </p>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 bg-white border border-fluent-border text-fluent-text rounded-xl text-sm font-medium hover:bg-fluent-bg transition-all">
                        Cancel
                    </button>
                    <form action="{{ route('lecture-locations.destroy', encrypt($lectureLocation->id)) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                if (loader) {
                    loader.classList.add('hidden');
                    setTimeout(() => loader.remove(), 200);
                }
            }, 200);
        });

        // Simple Delete Modal Functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Mobile toggle
        const sidebarLeft = document.getElementById('sidebarLeft');
        const sidebarRight = document.getElementById('sidebarRight');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileRightToggle = document.getElementById('mobileRightToggle');

        function closeAllSidebars() {
            sidebarLeft.classList.remove('open');
            sidebarRight.classList.remove('open');
            overlay.classList.remove('active');
            overlay.style.display = 'none';
        }

        function openSidebar(sidebar) {
            closeAllSidebars();
            sidebar.classList.add('open');
            overlay.style.display = 'block';
            setTimeout(() => overlay.classList.add('active'), 10);
        }

        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarLeft.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarLeft);
        });

        mobileRightToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarRight.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarRight);
        });

        overlay.addEventListener('click', closeAllSidebars);
    </script>
</body>

</html>