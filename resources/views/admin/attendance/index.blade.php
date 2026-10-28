{{-- resources/views/admin/attendance/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance — DipTek Attendance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.dataTables.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fluent: {
                            blue: '#0078D4', darkBlue: '#106EBE', lightBlue: '#D0E7F8',
                            bg: '#FAF9F8', text: '#1B1A19', secondary: '#605E5C',
                            border: '#EDEBE9', success: '#107C10', warning: '#FF8C00', error: '#D13438',
                        },
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        * { -webkit-font-smoothing: antialiased; }
        .btn-sleek { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-sleek:active { transform: scale(0.97); }
        .btn-sleek-primary { background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%); border: 1px solid #106EBE; }
        .btn-sleek-primary:hover { background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%); box-shadow: 0 4px 8px rgba(0,120,212,0.25); }

        .dataTables_wrapper .dataTables_filter input {
            padding: 8px 12px; border: 1px solid #EDEBE9; border-radius: 8px; margin-left: 10px; min-width: 250px;
        }
        .dataTables_wrapper .dataTables_filter input:focus { outline: none; border-color: #0078D4; box-shadow: 0 0 0 3px rgba(0,120,212,0.1); }
        .dataTables_wrapper .dataTables_length select { padding: 6px 10px; border: 1px solid #EDEBE9; border-radius: 8px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 6px 12px; border: 1px solid #EDEBE9; border-radius: 8px; margin: 0 3px; background: white; color: #605E5C !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #0078D4 !important; border-color: #0078D4 !important; color: white !important; }
        table.dataTable thead th { background: #FAF9F8; padding: 14px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #605E5C; }
        table.dataTable tbody td { padding: 14px 20px; font-size: 14px; border-bottom: 1px solid #EDEBE9; }
        table.dataTable tbody tr:hover { background: #F8F8F8; }
        table.dataTable tbody td.dataTables_empty { text-align: center; padding: 40px 20px; color: #605E5C; font-size: 14px; }
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before { background-color: #0078D4; border: none; box-shadow: none; }
    </style>
</head>

<body class="bg-fluent-bg font-sans antialiased">

    <div class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">
        @include('inc.sidebar')

        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('dashboard') }}" class="text-fluent-secondary hover:text-fluent-text">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Dashboard</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Attendance</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Attendance</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Manage student attendance records</p>
                </div>
                <a href="{{ route('attendance.create') }}"
                    class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-white rounded-xl text-sm font-semibold">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Add Attendance
                </a>
            </div>

            {{-- Messages --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-2xl p-4 border border-fluent-border">
                <table id="attendanceTable" class="display responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Date</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Distance</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendance as $index => $record)
                            <tr>
                                <td class="text-sm font-semibold text-fluent-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-fluent-success/10 flex items-center justify-center text-fluent-success font-semibold text-sm">
                                            {{ strtoupper(substr($record->student->name ?? 'NA', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-sm">{{ $record->student->name ?? 'N/A' }}</span>
                                            <p class="text-xs text-fluent-secondary">{{ $record->student->student_number ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-semibold text-sm">{{ $record->timetable?->course?->title ?? 'N/A' }}</span>
                                    <p class="text-xs text-fluent-secondary">{{ $record->timetable?->course?->code ?? '' }}</p>
                                </td>
                                <td class="text-sm">
                                    {{ $record->session_date ? \Carbon\Carbon::parse($record->session_date)->format('M d, Y') : ($record->clock_in_time ? $record->clock_in_time->format('M d, Y') : 'N/A') }}
                                </td>
                                <td class="text-sm font-medium">
                                    {{ $record->clock_in_time ? $record->clock_in_time->format('H:i') : 'N/A' }}
                                </td>
                                <td class="text-sm">
                                    {{ $record->clock_out_time ? $record->clock_out_time->format('H:i') : '—' }}
                                </td>
                                <td class="text-sm">
                                    @if($record->distance_meters)
                                        {{ number_format($record->distance_meters, 1) }}m
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if($record->status === 'present')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-fluent-success/10 text-fluent-success">
                                            <span class="w-1.5 h-1.5 bg-fluent-success rounded-full"></span>Present
                                        </span>
                                    @elseif($record->status === 'late')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-fluent-warning/10 text-fluent-warning">
                                            <span class="w-1.5 h-1.5 bg-fluent-warning rounded-full"></span>Late
                                        </span>
                                    @elseif($record->status === 'absent')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-fluent-error/10 text-fluent-error">
                                            <span class="w-1.5 h-1.5 bg-fluent-error rounded-full"></span>Absent
                                        </span>
                                    @elseif($record->status === 'excused')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Excused
                                        </span>
                                    @endif
                                </td>
                                <td class="text-xs">
                                    <span class="px-2 py-1 bg-gray-100 rounded-md capitalize">{{ $record->source }}</span>
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        {{-- Action links --}}
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

        @include('inc.quick_access')
    </div>

    <script>
        $(document).ready(function() {
            $('#attendanceTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [[3, 'desc']],
                columnDefs: [{
                    targets: -1, // Actions (last column)
                    orderable: false,
                    searchable: false
                }],
                language: {
                    search: "",
                    searchPlaceholder: "Search attendance...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered from _MAX_ total)",
                    emptyTable: "No attendance records found",
                    zeroRecords: "No matching attendance records found",
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" }
                }
            });
        });
    </script>
</body>
</html>