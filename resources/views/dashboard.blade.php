<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — DipTek Attendance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
                        sidebar: {
                            bg: '#0a0e17', text: '#e2e8f0', muted: '#94a3b8',
                            label: '#64748b', border: 'rgba(255,255,255,0.06)', hover: 'rgba(255,255,255,0.04)',
                        }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    boxShadow: {
                        'card': '0 1px 2px rgba(0,0,0,0.04)',
                    },
                }
            }
        }
    </script>

    @include('inc.styles')
</head>

<body class="bg-fluent-bg font-sans antialiased">

    {{-- Mobile Toggles --}}
    <button class="lg:hidden fixed top-3.5 left-3.5 z-[100] w-[38px] h-[38px] rounded-md border border-fluent-border bg-white cursor-pointer flex items-center justify-center text-fluent-text shadow-sm" id="mobileToggle">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
            <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <button class="lg:hidden fixed top-3.5 right-3.5 z-[100] w-[38px] h-[38px] rounded-md border border-fluent-border bg-white cursor-pointer flex items-center justify-center text-fluent-text shadow-sm" id="mobileRightToggle">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
            <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/>
        </svg>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">
        @include('inc.sidebar')

        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            {{-- Page header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-7 gap-4">
                <div>
                    <h1 class="text-xl font-semibold text-fluent-text">
                        Welcome back, {{ Auth::user()->name ?? 'Admin' }}
                    </h1>
                    <p class="text-sm text-fluent-secondary mt-1">
                        {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href=""
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-white bg-fluent-blue hover:bg-fluent-darkBlue rounded-md text-sm font-medium transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <line x1="19" y1="8" x2="19" y2="14"/>
                            <line x1="22" y1="11" x2="16" y2="11"/>
                        </svg>
                        Add Student
                    </a>
                    <a href=""
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-fluent-text bg-white border border-fluent-border hover:bg-gray-50 rounded-md text-sm font-medium transition-colors">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Add Timetable
                    </a>
                </div>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

                {{-- Total Students --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-9 h-9 rounded-md flex items-center justify-center bg-fluent-blue/10 text-fluent-blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        @if($newStudents7d > 0)
                            <span class="text-xs font-medium text-fluent-success">
                                +{{ $newStudents7d }} this week
                            </span>
                        @endif
                    </div>
                    <p class="text-xs font-medium text-fluent-secondary uppercase tracking-wide mb-1">Total Students</p>
                    <p class="text-2xl font-semibold text-fluent-text">{{ number_format($students) }}</p>
                </div>

                {{-- Total Lecturers --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-9 h-9 rounded-md flex items-center justify-center bg-fluent-success/10 text-fluent-success">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        @if($newLecturers7d > 0)
                            <span class="text-xs font-medium text-fluent-success">
                                +{{ $newLecturers7d }} this week
                            </span>
                        @endif
                    </div>
                    <p class="text-xs font-medium text-fluent-secondary uppercase tracking-wide mb-1">Total Lecturers</p>
                    <p class="text-2xl font-semibold text-fluent-text">{{ number_format($lecturers) }}</p>
                </div>

                {{-- Today's Attendance --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-9 h-9 rounded-md flex items-center justify-center bg-fluent-blue/10 text-fluent-blue">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-fluent-secondary">Today</span>
                    </div>
                    <p class="text-xs font-medium text-fluent-secondary uppercase tracking-wide mb-1">Today's Attendance</p>
                    <p class="text-2xl font-semibold text-fluent-text">{{ $todayRate }}%</p>
                    <p class="text-xs text-fluent-secondary mt-1">
                        {{ number_format($todayPresent) }} of {{ number_format($todayTotal) }} present
                    </p>
                </div>

                {{-- Total Courses --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-9 h-9 rounded-md flex items-center justify-center bg-fluent-secondary/10 text-fluent-secondary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-fluent-secondary uppercase tracking-wide mb-1">Total Courses</p>
                    <p class="text-2xl font-semibold text-fluent-text">{{ number_format($courses) }}</p>
                    <p class="text-xs text-fluent-secondary mt-1">{{ $departments }} departments</p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-7">

                <div class="lg:col-span-3 bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-fluent-text">Attendance Overview</h3>
                            <p class="text-xs text-fluent-secondary mt-0.5">Last 7 days</p>
                        </div>
                        <select class="px-2.5 py-1.5 border border-fluent-border rounded-md text-xs text-fluent-secondary bg-white focus:outline-none focus:ring-1 focus:ring-fluent-blue cursor-pointer">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>This semester</option>
                        </select>
                    </div>
                    <div class="h-[260px] relative">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-fluent-text">Students by Department</h3>
                            <p class="text-xs text-fluent-secondary mt-0.5">Top {{ count($deptChart['labels']) }}</p>
                        </div>
                    </div>
                    <div class="h-[260px] relative">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Recent + Upcoming --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Recent Attendance --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-fluent-text">Recent Attendance</h3>
                            <p class="text-xs text-fluent-secondary mt-0.5">Latest clock-ins</p>
                        </div>
                        <a href="{{ route('attendance.index') }}"
                            class="text-xs text-fluent-blue hover:underline font-medium">
                            View all
                        </a>
                    </div>

                    @forelse($recent as $record)
                        @php
                            $badge = match($record->status) {
                                'present' => 'text-green-700 bg-green-50',
                                'late'    => 'text-yellow-700 bg-yellow-50',
                                'absent'  => 'text-red-700 bg-red-50',
                                'excused' => 'text-blue-700 bg-blue-50',
                                default   => 'text-gray-700 bg-gray-50',
                            };
                            $avatarBg = match($record->status) {
                                'present' => 'bg-fluent-blue',
                                'late'    => 'bg-fluent-warning',
                                'absent'  => 'bg-fluent-error',
                                'excused' => 'bg-blue-500',
                                default   => 'bg-gray-400',
                            };
                            $initials = strtoupper(substr($record->student->name ?? 'NA', 0, 2));
                        @endphp
                        <div class="flex items-center gap-3 py-2.5 border-b border-fluent-border last:border-0">
                            <div class="w-8 h-8 rounded-full {{ $avatarBg }} flex items-center justify-center text-white font-medium text-xs shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-fluent-text truncate">
                                    {{ $record->student->name ?? 'Unknown Student' }}
                                </p>
                                <p class="text-xs text-fluent-secondary truncate">
                                    {{ $record->timetable?->course?->code ?? 'N/A' }}
                                    @if($record->clock_in_time)
                                        · {{ $record->clock_in_time->format('h:i A') }}
                                    @endif
                                </p>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $badge }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <p class="text-sm text-fluent-secondary">No attendance records yet</p>
                        </div>
                    @endforelse
                </div>

                {{-- Today's Classes --}}
                <div class="bg-white rounded-lg p-5 shadow-card border border-fluent-border">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-fluent-text">Today's Classes</h3>
                            <p class="text-xs text-fluent-secondary mt-0.5">{{ now()->format('l') }}</p>
                        </div>
                        <a href="{{ route('timetables.index') }}"
                            class="text-xs text-fluent-blue hover:underline font-medium">
                            Full timetable
                        </a>
                    </div>

                    @forelse($upcoming as $class)
                        @php
                            $start = \Carbon\Carbon::parse($class->start_time);
                            $isOngoing = now()->between($start, \Carbon\Carbon::parse($class->end_time));
                        @endphp
                        <div class="flex items-center gap-3 py-2.5 border-b border-fluent-border last:border-0">
                            <div class="flex flex-col items-center min-w-[52px] py-1">
                                <span class="text-sm font-semibold text-fluent-text">{{ $start->format('H:i') }}</span>
                                <span class="text-[10px] text-fluent-secondary uppercase">{{ $start->format('A') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-fluent-text truncate">
                                    {{ $class->course?->title ?? 'Unknown Course' }}
                                </p>
                                <p class="text-xs text-fluent-secondary truncate">
                                    {{ $class->location?->name ?? 'No location' }}
                                    @if($class->lecturer)
                                        · {{ $class->lecturer->name }}
                                    @endif
                                </p>
                            </div>
                            <span class="text-[11px] font-medium {{ $isOngoing ? 'text-green-700' : 'text-fluent-secondary' }}">
                                {{ $isOngoing ? 'Ongoing' : 'Upcoming' }}
                            </span>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <p class="text-sm text-fluent-secondary">No classes scheduled for today</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>

        @include('inc.quick_access')
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
        Chart.defaults.color = '#605E5C';

        document.addEventListener('DOMContentLoaded', function () {
            initAttendanceChart();
            initDepartmentChart();
        });

        function initAttendanceChart() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chart['labels']),
                    datasets: [
                        {
                            label: 'Present',
                            data: @json($chart['present']),
                            borderColor: '#0078D4',
                            backgroundColor: 'rgba(0, 120, 212, 0.08)',
                            tension: 0.35, fill: true, borderWidth: 2,
                            pointBackgroundColor: '#0078D4',
                            pointBorderColor: '#fff', pointBorderWidth: 2,
                            pointRadius: 3, pointHoverRadius: 5,
                        },
                        {
                            label: 'Late',
                            data: @json($chart['late']),
                            borderColor: '#FF8C00',
                            backgroundColor: 'rgba(255, 140, 0, 0.06)',
                            tension: 0.35, fill: true, borderWidth: 2,
                            pointBackgroundColor: '#FF8C00',
                            pointBorderColor: '#fff', pointBorderWidth: 2,
                            pointRadius: 3, pointHoverRadius: 5,
                        },
                        {
                            label: 'Absent',
                            data: @json($chart['absent']),
                            borderColor: '#D13438',
                            backgroundColor: 'rgba(209, 52, 56, 0.06)',
                            tension: 0.35, fill: true, borderWidth: 2,
                            pointBackgroundColor: '#D13438',
                            pointBorderColor: '#fff', pointBorderWidth: 2,
                            pointRadius: 3, pointHoverRadius: 5,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 16, font: { size: 11 } }
                        },
                        tooltip: {
                            backgroundColor: '#1B1A19',
                            padding: 10,
                            cornerRadius: 6,
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 12 },
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        function initDepartmentChart() {
            const ctx = document.getElementById('departmentChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($deptChart['labels']),
                    datasets: [{
                        data: @json($deptChart['data']),
                        backgroundColor: ['#0078D4', '#107C10', '#FF8C00', '#7C3AED', '#D13438'],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 14, font: { size: 11 } }
                        },
                        tooltip: {
                            backgroundColor: '#1B1A19',
                            padding: 10,
                            cornerRadius: 6,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                    return context.label + ': ' + context.parsed + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Mobile sidebar
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

        if (overlay) overlay.addEventListener('click', closeAllSidebars);

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                closeAllSidebars();
            }
        });
    </script>
</body>
</html>