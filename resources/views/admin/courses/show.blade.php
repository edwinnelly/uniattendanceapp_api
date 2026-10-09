{{-- resources/views/admin/courses/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} — DipTek Attendance</title>

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

        /* Modal Animation */
        .modal-overlay {
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
                        <a href="{{ route('courses.index') }}"
                            class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Courses</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">{{ $course->code }}</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">{{ $course->title }}</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Course Details</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('courses.edit', encrypt($course->id)) }}"
                        class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('courses.index') }}"
                        class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                        Back
                    </a>
                </div>
            </div>

            <!-- Course Details Card -->
            <div class="bg-white rounded-2xl shadow-card border border-fluent-border p-6 lg:p-8 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Course Title</p>
                        <p class="text-lg font-semibold text-fluent-text">{{ $course->title }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Course Code</p>
                        <span
                            class="px-3 py-1 bg-fluent-lightBlue text-fluent-blue rounded-lg text-sm font-bold">{{ $course->code }}</span>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Department</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            {{ $course->department ? $course->department->name : 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Level</p>
                        <p class="text-lg font-semibold text-fluent-text">
                            {{ $course->level ? $course->level->name : 'All Levels' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Credit Hours</p>
                        <p class="text-lg font-semibold text-fluent-text">{{ $course->credit_hours }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Status</p>
                        @if ($course->is_active)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-fluent-success/10 text-fluent-success">
                                <span class="w-1.5 h-1.5 bg-fluent-success rounded-full"></span>Active
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-fluent-error/10 text-fluent-error">
                                <span class="w-1.5 h-1.5 bg-fluent-error rounded-full"></span>Inactive
                            </span>
                        @endif
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Description</p>
                        <p class="text-sm text-fluent-text">{{ $course->description ?? 'No description provided' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Created At</p>
                        <p class="text-sm text-fluent-text">{{ $course->created_at->format('F j, Y') }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-fluent-secondary uppercase tracking-wider mb-1">Last Updated</p>
                        <p class="text-sm text-fluent-text">{{ $course->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone with Fancy Delete Button -->
            <div class="bg-white border border-red-200 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-fluent-text">Please Note</h3>
                        <p class="text-sm text-fluent-secondary mt-1">Permanently delete this course and all associated data.</p>
                    </div>
                    <button onclick="openDeleteModal()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl text-sm font-semibold hover:bg-red-600 transition-all">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        Delete Course
                    </button>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        @include('inc.quick_access')
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[200] hidden">
        <!-- Overlay -->
        <div class="modal-overlay absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

        <!-- Modal Content -->
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8">
                <!-- Warning Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D13438"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-fluent-text text-center mb-2">Delete Course?</h2>

                <!-- Description -->
                <p class="text-sm text-fluent-secondary text-center mb-6">
                    You are about to delete <strong class="text-fluent-text">{{ $course->title }}</strong>.
                    This action cannot be undone.
                </p>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 px-5 py-3 bg-white border border-fluent-border text-fluent-text rounded-xl text-sm font-semibold hover:bg-fluent-bg transition-all">
                        Cancel
                    </button>
                    <form action="{{ route('courses.destroy', encrypt($course->id)) }}" method="POST"
                        class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-5 py-3 bg-red-500 text-white rounded-xl text-sm font-semibold hover:bg-red-600 transition-all flex items-center justify-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
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

        // Delete Modal Functions
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