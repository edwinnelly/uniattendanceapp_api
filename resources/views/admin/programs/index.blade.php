{{-- resources/views/admin/programs/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Faculty — DipTek Attendance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

        .btn-sleek {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-sleek:active { transform: scale(0.97); }

        .btn-sleek-primary {
            background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%);
            border: 1px solid #106EBE;
        }

        .btn-sleek-primary:hover {
            background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%);
            box-shadow: 0 4px 8px rgba(0, 120, 212, 0.25);
        }

        .dataTables_wrapper { font-family: 'Inter', sans-serif; }

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
            outline: none;
        }

        .dataTables_wrapper .dataTables_length select:focus { border-color: #0078D4; }

        .dataTables_wrapper .dataTables_filter label {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter label::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23605E5C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            pointer-events: none;
            z-index: 1;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 10px 14px 10px 38px;
            border: 1px solid #EDEBE9;
            border-radius: 10px;
            background: white;
            min-width: 280px;
            width: 100%;
            transition: all 0.2s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #0078D4;
            box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.1);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 7px 13px;
            border: 1px solid #EDEBE9;
            border-radius: 8px;
            margin: 0 3px;
            background: white;
            color: #605E5C !important;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
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
            white-space: nowrap;
        }

        table.dataTable tbody td {
            border-bottom: 1px solid #EDEBE9;
            padding: 16px 20px;
            font-size: 14px;
            vertical-align: middle;
        }

        table.dataTable tbody tr { transition: background-color 0.15s ease; }
        table.dataTable tbody tr:hover { background: #F8F8F8; }
        table.dataTable tbody tr:last-child td { border-bottom: none; }

        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
            background-color: #0078D4;
            border: none;
            box-shadow: none;
            border-radius: 6px;
            height: 22px;
            width: 22px;
            line-height: 22px;
            font-size: 12px;
            margin-right: 12px;
        }

        .program-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            color: white;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.18s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .action-btn:hover { transform: translateY(-1px); }
        .action-btn:active { transform: translateY(0) scale(0.96); }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 38px;
            height: 20px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #E5E7EB;
            transition: 0.25s;
            border-radius: 20px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.25s;
            border-radius: 50%;
        }

        .toggle-switch input:checked + .toggle-slider { background-color: #107C10; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(18px); }
        .toggle-switch input:disabled + .toggle-slider { opacity: 0.5; cursor: not-allowed; }

        .empty-state { padding: 64px 24px; text-align: center; }

        .stat-card { transition: box-shadow 0.2s ease; }
        .stat-card:hover { box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05); }

        .fade-in { animation: fadeIn 0.3s ease-out both; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
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
            .dataTables_wrapper .dataTables_filter input { min-width: 100%; }
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
                        <a href="{{ route('dashboard') }}"
                            class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-fluent-secondary">Dashboard</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="font-semibold text-fluent-text">Faculty</span>
                    </div>
                    <h1 class="text-2xl font-bold text-fluent-text tracking-tight">Faculty</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Academic programs offered by the school.</p>
                </div>
                <a href="{{ route('programs.create') }}"
                    class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white rounded-lg text-sm font-semibold">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add Faculty
                </a>
            </div>

            @php
                $totalPrograms = $programs->count();
                $activePrograms = $programs->where('is_active', true)->count();
                $inactivePrograms = $totalPrograms - $activePrograms;
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="stat-card bg-white rounded-xl border border-fluent-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-fluent-lightBlue flex items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0078D4"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                            <path d="M6 12v5c3 3 9 3 12 0v-5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-fluent-text leading-none">{{ $totalPrograms }}</div>
                        <div class="text-xs text-fluent-secondary mt-1">Total programs</div>
                    </div>
                </div>
                <div class="stat-card bg-white rounded-xl border border-fluent-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#107C10"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-fluent-text leading-none">{{ $activePrograms }}</div>
                        <div class="text-xs text-fluent-secondary mt-1">Active</div>
                    </div>
                </div>
                <div class="stat-card bg-white rounded-xl border border-fluent-border p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#605E5C"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-fluent-text leading-none">{{ $inactivePrograms }}</div>
                        <div class="text-xs text-fluent-secondary mt-1">Inactive</div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-2.5 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-2.5 rounded-lg mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-fluent-border">
                <div class="px-5 py-4 border-b border-fluent-border flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-fluent-text">Programs</h2>
                    <span class="text-xs text-fluent-secondary">{{ $totalPrograms }} total</span>
                </div>

                <div class="p-5">
                    <table id="programsTable" class="display responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $program)
                                @php
                                    $palette = [
                                        'bg-blue-500',
                                        'bg-purple-500',
                                        'bg-emerald-500',
                                        'bg-orange-500',
                                        'bg-pink-500',
                                        'bg-indigo-500',
                                        'bg-teal-500',
                                        'bg-rose-500',
                                    ];
                                    $avatarBg = $palette[$program->id % count($palette)];
                                    $initials = strtoupper(
                                        collect(explode(' ', $program->name))
                                            ->filter()
                                            ->take(2)
                                            ->map(fn($w) => mb_substr($w, 0, 1))
                                            ->implode(''),
                                    );
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="program-avatar {{ $avatarBg }}">
                                                {{ $initials ?: '?' }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-fluent-text truncate max-w-[240px]"
                                                    title="{{ $program->name }}">
                                                    {{ $program->name }}
                                                </div>
                                                <div class="text-xs text-fluent-secondary mt-0.5">
                                                    Added {{ $program->created_at?->diffForHumans() ?? '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 bg-fluent-lightBlue text-fluent-blue rounded text-xs font-semibold">
                                            {{ $program->code }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-sm text-fluent-secondary line-clamp-2 max-w-[320px] block"
                                            title="{{ $program->description ?? 'No description' }}">
                                            {{ $program->description ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            <label class="toggle-switch" title="Toggle status">
                                                <input type="checkbox" class="program-status-toggle"
                                                    data-url="{{ route('programs.toggle', encrypt($program->id)) }}"
                                                    {{ $program->is_active ? 'checked' : '' }}>
                                                <span class="toggle-slider"></span>
                                            </label>
                                            <span
                                                class="status-text text-xs font-medium {{ $program->is_active ? 'text-fluent-success' : 'text-fluent-secondary' }}">
                                                {{ $program->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('programs.show', encrypt($program->id)) }}"
                                                class="action-btn text-fluent-blue hover:bg-fluent-lightBlue"
                                                title="View">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('programs.edit', encrypt($program->id)) }}"
                                                class="action-btn text-fluent-warning hover:bg-amber-50"
                                                title="Edit">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </a>
                                            <button type="button"
                                                class="action-btn text-fluent-error hover:bg-red-50 delete-program-btn"
                                                data-name="{{ $program->name }}"
                                                data-url="{{ route('programs.destroy', encrypt($program->id)) }}"
                                                title="Delete">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="text-xs text-fluent-secondary text-center mt-6">DipTek Attendance &middot; Faculty</p>
        </main>

        @include('inc.quick_access')
    </div>

    <div id="deleteModal"
        class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-black/40">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-5 fade-in">
            <h3 class="text-base font-bold text-fluent-text">Delete Faculty?</h3>
            <p class="text-sm text-fluent-secondary mt-2">
                <span id="deleteProgramName" class="font-semibold text-fluent-text"></span>
                will be permanently removed. This cannot be undone.
            </p>
            <div class="flex items-center justify-end gap-2 mt-5">
                <button type="button" id="cancelDelete"
                    class="px-4 py-2 text-sm font-medium text-fluent-secondary bg-fluent-bg border border-fluent-border rounded-lg hover:bg-gray-100">
                    Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-fluent-error rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        $(function () {
            setTimeout(() => {
                $('#pageLoader').addClass('hidden');
                setTimeout(() => $('#pageLoader').remove(), 200);
            }, 200);

            $('#programsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [[0, 'asc']],
                columnDefs: [
                    { targets: -1, orderable: false, searchable: false, className: 'text-right' }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search programs…",
                    lengthMenu: "Show _MENU_",
                    info: "_START_–_END_ of _TOTAL_",
                    infoEmpty: "No programs",
                    infoFiltered: "(of _MAX_)",
                    emptyTable: `
                        <div class="empty-state">
                            <h3 class="text-sm font-semibold text-fluent-text mb-1">No programs yet</h3>
                            <p class="text-sm text-fluent-secondary mb-4">Add your first program to get started.</p>
                            <a href="{{ route('programs.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 text-white bg-fluent-blue rounded-lg text-sm font-semibold hover:bg-fluent-darkBlue">
                                New Program
                            </a>
                        </div>
                    `,
                    zeroRecords: `
                        <div class="empty-state">
                            <h3 class="text-sm font-semibold text-fluent-text mb-1">No matches</h3>
                            <p class="text-sm text-fluent-secondary">Try a different search.</p>
                        </div>
                    `,
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Prev" }
                }
            });

            $(document).on('change', '.program-status-toggle', function () {
                const $toggle = $(this);
                const $label = $toggle.closest('td').find('.status-text');
                const wasChecked = $toggle.prop('checked');

                $toggle.prop('disabled', true);

                $.ajax({
                    url: $toggle.data('url'),
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                    success: function (res) {
                        const active = res.is_active ?? wasChecked;
                        $label
                            .text(active ? 'Active' : 'Inactive')
                            .toggleClass('text-fluent-success', active)
                            .toggleClass('text-fluent-secondary', !active);
                    },
                    error: function () {
                        $toggle.prop('checked', !wasChecked);
                        toast('Could not update status.', 'error');
                    },
                    complete: function () {
                        $toggle.prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.delete-program-btn', function () {
                $('#deleteProgramName').text($(this).data('name'));
                $('#deleteForm').attr('action', $(this).data('url'));
                $('#deleteModal').removeClass('hidden').addClass('flex');
            });

            function closeDelete() {
                $('#deleteModal').addClass('hidden').removeClass('flex');
            }

            $('#cancelDelete').on('click', closeDelete);
            $('#deleteModal').on('click', function (e) {
                if (e.target === this) closeDelete();
            });
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') closeDelete();
            });

            function toast(message, type) {
                const bg = type === 'error' ? 'bg-red-600' : 'bg-fluent-blue';
                const $el = $(`<div class="fixed bottom-6 right-6 z-[300] ${bg} text-white px-4 py-2.5 rounded-lg shadow-lg text-sm">${message}</div>`);
                $('body').append($el);
                setTimeout(() => $el.fadeOut(200, () => $el.remove()), 2800);
            }
        });

        const overlay = document.getElementById('sidebarOverlay');
        const sidebarLeft = document.getElementById('sidebarLeft');
        const sidebarRight = document.getElementById('sidebarRight');
        const toggleLeft = document.getElementById('mobileToggle');
        const toggleRight = document.getElementById('mobileRightToggle');

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

        toggleLeft?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarLeft?.classList.contains('open') ? closeAll() : open(sidebarLeft);
        });

        toggleRight?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarRight?.classList.contains('open') ? closeAll() : open(sidebarRight);
        });

        overlay?.addEventListener('click', closeAll);
    </script>
</body>

</html>