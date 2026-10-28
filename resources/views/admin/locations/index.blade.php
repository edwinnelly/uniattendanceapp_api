{{-- resources/views/admin/lecture-locations/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Locations — DipTek Attendance</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

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

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            font-family: 'Inter', sans-serif;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 13px;
            color: #605E5C;
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 6px 10px;
            border: 1px solid #EDEBE9;
            border-radius: 8px;
            margin: 0 5px;
            background: white;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 8px 12px 8px 35px;
            border: 1px solid #EDEBE9;
            border-radius: 8px;
            margin-left: 10px;
            background: white;
            min-width: 250px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #0078D4;
            box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.1);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            border: 1px solid #EDEBE9;
            border-radius: 8px;
            margin: 0 3px;
            background: white;
            color: #605E5C !important;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #FAF9F8 !important;
            border-color: #D1D5DB !important;
            color: #1B1A19 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0078D4 !important;
            border-color: #0078D4 !important;
            color: white !important;
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        table.dataTable {
            border-collapse: collapse;
            width: 100%;
        }

        table.dataTable thead th {
            background: #FAF9F8;
            border-bottom: 1px solid #EDEBE9;
            padding: 14px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #605E5C;
        }

        table.dataTable tbody td {
            border-bottom: 1px solid #EDEBE9;
            padding: 14px 20px;
            font-size: 14px;
        }

        table.dataTable tbody tr:hover {
            background: #F8F8F8;
        }

        /* Empty state */
        table.dataTable tbody td.dataTables_empty {
            text-align: center;
            padding: 40px 20px;
            color: #605E5C;
            font-size: 14px;
        }

        /* Responsive expand button */
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
            background-color: #0078D4;
            border: none;
            box-shadow: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge-active {
            background: rgba(16, 124, 16, 0.1);
            color: #107C10;
        }

        .status-badge-active .dot {
            background: #107C10;
        }

        .status-badge-inactive {
            background: rgba(209, 52, 56, 0.1);
            color: #D13438;
        }

        .status-badge-inactive .dot {
            background: #D13438;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
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
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('dashboard') }}"
                            class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Dashboard</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Lecture Locations</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Lecture Locations</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Manage your school's lecture venues and classrooms</p>
                </div>
                <a href="{{ route('lecture-locations.create') }}"
                    class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add Location
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-fluent-border p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-fluent-secondary uppercase tracking-wide">Total Locations</p>
                            <p class="text-2xl font-bold text-fluent-text mt-1">
                                {{ method_exists($locations, 'total') ? $locations->total() : $locations->count() }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-fluent-lightBlue flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0078D4" stroke-width="2">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-fluent-border p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-fluent-secondary uppercase tracking-wide">Active Locations</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">
                                {{ $locations->where('is_active', true)->count() }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#107C10" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-fluent-border p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-fluent-secondary uppercase tracking-wide">Total Capacity</p>
                            <p class="text-2xl font-bold text-fluent-text mt-1">
                                {{ $locations->sum('capacity') ?: 'N/A' }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF8C00" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-fluent-border p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-fluent-secondary uppercase tracking-wide">Buildings</p>
                            <p class="text-2xl font-bold text-fluent-text mt-1">
                                {{ $locations->pluck('building')->filter()->unique()->count() }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2">
                                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                                <line x1="8" y1="6" x2="16" y2="6"/>
                                <line x1="8" y1="10" x2="16" y2="10"/>
                                <line x1="8" y1="14" x2="12" y2="14"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locations Table with DataTables -->
            <div class="bg-white rounded-2xl p-4 border border-fluent-border">
                <table id="locationsTable" class="display responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Building</th>
                            <th>Room</th>
                            <th>Capacity</th>
                            <th>Coordinates</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $index => $location)
                            <tr>
                                <td class="text-sm font-semibold text-fluent-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <span class="font-semibold text-sm">{{ $location->name }}</span>
                                </td>
                                <td>
                                    <span
                                        class="px-2.5 py-1 bg-fluent-lightBlue text-fluent-blue rounded-md text-xs font-bold">{{ $location->code }}</span>
                                </td>
                                <td class="text-sm">
                                    {{ $location->building ?? '—' }}
                                </td>
                                <td class="text-sm">
                                    {{ $location->room_number ? 'Room ' . $location->room_number : '—' }}
                                    @if($location->floor)
                                        <span class="text-xs text-fluent-secondary">(Floor {{ $location->floor }})</span>
                                    @endif
                                </td>
                                <td class="text-sm">
                                    @if($location->capacity)
                                        <span class="font-semibold">{{ $location->capacity }}</span>
                                        <span class="text-fluent-secondary text-xs">seats</span>
                                    @else
                                        <span class="text-fluent-secondary text-xs">Unlimited</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs text-fluent-secondary">
                                            {{ number_format($location->latitude, 6) }},
                                            {{ number_format($location->longitude, 6) }}
                                        </span>
                                        <a href="{{ $location->google_maps_url }}" target="_blank"
                                            class="text-fluent-blue hover:text-fluent-darkBlue transition-colors" title="View on Maps">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                                <circle cx="12" cy="9" r="2.5"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if($location->is_active)
                                        <span class="status-badge status-badge-active">
                                            <span class="status-dot"></span>Active
                                        </span>
                                    @else
                                        <span class="status-badge status-badge-inactive">
                                            <span class="status-dot"></span>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        <a href="{{ route('lecture-locations.show', encrypt($location->id)) }}"
                                            class="p-1.5 rounded text-fluent-blue hover:bg-fluent-lightBlue transition-colors"
                                            title="View">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('lecture-locations.edit', encrypt($location->id)) }}"
                                            class="p-1.5 rounded text-fluent-warning hover:bg-fluent-warning/10 transition-colors"
                                            title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            onclick="confirmDelete('{{ encrypt($location->id) }}', {{ json_encode($location->name) }})"
                                            class="p-1.5 rounded text-fluent-error hover:bg-fluent-error/10 transition-colors"
                                            title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- DataTables handles empty state via language.emptyTable --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Right Sidebar -->
        @include('inc.quick_access')
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D13438" stroke-width="2">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-fluent-text">Delete Location</h3>
                    <p class="text-sm text-fluent-secondary">This action cannot be undone</p>
                </div>
            </div>
            <p class="text-sm text-fluent-text mb-6">
                Are you sure you want to delete <span id="deleteLocationName" class="font-semibold"></span>?
            </p>
            <form id="deleteForm" method="POST" class="flex gap-3 justify-end">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 rounded-xl border border-fluent-border text-fluent-secondary hover:bg-gray-50 transition-colors text-sm font-medium">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-fluent-error text-white hover:bg-red-700 transition-colors text-sm font-medium">
                    Delete Location
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#pageLoader').addClass('hidden');
                setTimeout(() => $('#pageLoader').remove(), 200);
            }, 200);

            $('#locationsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: -1, // Actions (last column)
                    orderable: false,
                    searchable: false
                }],
                language: {
                    search: "",
                    searchPlaceholder: "Search locations...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ locations",
                    infoEmpty: "No locations found",
                    emptyTable: "No lecture locations found",
                    zeroRecords: "No matching locations found",
                    infoFiltered: "(filtered from _MAX_ total)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });

            // Auto-hide success/error messages after 5 seconds
            setTimeout(function() {
                $('.bg-green-50, .bg-red-50').fadeOut('slow');
            }, 5000);
        });

        // Mobile toggle
        const sidebarLeft = document.getElementById('sidebarLeft');
        const sidebarRight = document.getElementById('sidebarRight');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileRightToggle = document.getElementById('mobileRightToggle');

        function closeAllSidebars() {
            if (sidebarLeft) sidebarLeft.classList.remove('open');
            if (sidebarRight) sidebarRight.classList.remove('open');
            if (overlay) {
                overlay.classList.remove('active');
                overlay.style.display = 'none';
            }
        }

        function openSidebar(sidebar) {
            if (!sidebar) return;
            closeAllSidebars();
            sidebar.classList.add('open');
            if (overlay) {
                overlay.style.display = 'block';
                setTimeout(() => overlay.classList.add('active'), 10);
            }
        }

        if (mobileToggle && sidebarLeft) {
            mobileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebarLeft.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarLeft);
            });
        }

        if (mobileRightToggle && sidebarRight) {
            mobileRightToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebarRight.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarRight);
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeAllSidebars);
        }

        // Delete confirmation
        function confirmDelete(encryptedId, name) {
            document.getElementById('deleteLocationName').textContent = name;
            document.getElementById('deleteForm').action = '{{ url('lecture-locations') }}/' + encryptedId;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal on backdrop click or Escape
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</body>

</html>