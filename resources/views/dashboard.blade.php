<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Attendance — Dashboard</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
                    boxShadow: {
                        'btn-primary': '0 1px 2px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.06)',
                        'btn-primary-hover': '0 4px 6px rgba(0,120,212,0.2), 0 2px 4px rgba(0,120,212,0.1)',
                        'btn-secondary': '0 1px 2px rgba(0,0,0,0.05)',
                        'btn-secondary-hover': '0 2px 4px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04)',
                        'card': '0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03)',
                        'card-hover': '0 8px 16px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.04)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    @include('inc.styles')
</head>

<body class="bg-fluent-bg font-sans antialiased">

    <!-- Page Loader -->
    <div id="pageLoader" class="fixed inset-0 bg-white z-[999] flex items-center justify-center flex-col gap-5 transition-opacity duration-300">
        <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
            <img src="{{ asset('logo/logo.png') }}" alt="DipTek Logo" class="w-8 h-8">
        </div>
        <div class="text-center">
            <div class="font-bold text-lg text-gray-800 uppercase tracking-wider">DipTek</div>
            <div class="text-xs text-gray-500 mt-1">Loading your dashboard...</div>
        </div>
    </div>

    <!-- Mobile Toggle (Left) -->
    <button class="lg:hidden fixed top-3.5 left-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 backdrop-blur-md cursor-pointer flex items-center justify-center text-fluent-text shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200" id="mobileToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="5" cy="12" r="1.5" />
            <circle cx="12" cy="12" r="1.5" />
            <circle cx="19" cy="12" r="1.5" />
        </svg>
    </button>

    <!-- Mobile Toggle (Right) -->
    <button class="lg:hidden fixed top-3.5 right-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 backdrop-blur-md cursor-pointer flex items-center justify-center text-fluent-text shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200" id="mobileRightToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9" />
            <polyline points="12 7 12 12 15 14" />
        </svg>
    </button>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">

        <!-- Left Sidebar -->
        @include('inc.sidebar')

        <!-- Main Content -->
        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            <!-- Welcome Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4 animate-fade-in">
                <div>
                    <h2 class="text-2xl font-extrabold text-fluent-text mb-2 tracking-tight">
                        Welcome back, {{ Auth::user()->name ?? 'Admin' }}!
                    </h2>
                    <p class="text-sm text-fluent-secondary">
                        Here's what's happening at your school today.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Sleek Primary Button -->
                    <button class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2.5 px-5 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" y1="8" x2="19" y2="14" />
                            <line x1="22" y1="11" x2="16" y2="11" />
                        </svg>
                        Add Student
                    </button>
                    
                    <!-- Sleek Secondary Button -->
                    <button class="btn-sleek btn-sleek-secondary inline-flex items-center justify-center gap-2.5 px-5 py-3 text-fluent-text rounded-xl text-sm font-semibold tracking-wide">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        Add Timetable
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 animate-slide-up">
                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 cursor-pointer group border border-fluent-border">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-fluent-blue/10 text-fluent-blue group-hover:scale-110 transition-all duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-fluent-secondary mb-1">Total Students</p>
                        <p class="text-3xl font-extrabold text-fluent-text mb-1">1,250</p>
                        <p class="text-xs text-fluent-success font-medium flex items-center gap-1">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 19V5M5 12l7-7 7 7" />
                            </svg>
                            +12 this week
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 cursor-pointer group border border-fluent-border">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-fluent-success/10 text-fluent-success group-hover:scale-110 transition-all duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-fluent-secondary mb-1">Total Lecturers</p>
                        <p class="text-3xl font-extrabold text-fluent-text mb-1">85</p>
                        <p class="text-xs text-fluent-success font-medium flex items-center gap-1">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 19V5M5 12l7-7 7 7" />
                            </svg>
                            +3 this month
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 cursor-pointer group border border-fluent-border">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-fluent-warning/10 text-fluent-warning group-hover:scale-110 transition-all duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-fluent-secondary mb-1">Today's Attendance</p>
                        <p class="text-3xl font-extrabold text-fluent-text mb-1">92%</p>
                        <p class="text-xs text-fluent-success font-medium">245 present</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 cursor-pointer group border border-fluent-border">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-purple-100 text-purple-600 group-hover:scale-110 transition-all duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-fluent-secondary mb-1">Total Courses</p>
                        <p class="text-3xl font-extrabold text-fluent-text mb-1">120</p>
                        <p class="text-xs text-fluent-success font-medium">+5 new</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 border border-fluent-border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-fluent-text">Attendance Overview</h3>
                        <select class="px-4 py-2 border border-fluent-border rounded-lg text-sm text-fluent-secondary bg-white focus:outline-none focus:ring-2 focus:ring-fluent-blue focus:border-transparent cursor-pointer">
                            <option>This Week</option>
                            <option>This Month</option>
                            <option>This Semester</option>
                        </select>
                    </div>
                    <div class="h-[300px] relative">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 border border-fluent-border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-fluent-text">Students by Department</h3>
                        <button class="text-fluent-secondary hover:text-fluent-text transition-colors p-2">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="5" r="2" />
                                <circle cx="12" cy="12" r="2" />
                                <circle cx="12" cy="19" r="2" />
                            </svg>
                        </button>
                    </div>
                    <div class="h-[300px] relative">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Upcoming Classes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 border border-fluent-border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-fluent-text">Recent Attendance</h3>
                        <a href="#" class="text-sm text-fluent-blue hover:text-fluent-darkBlue font-medium transition-colors flex items-center gap-1">
                            View All
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-fluent-bg transition-colors cursor-pointer">
                            <div class="w-10 h-10 rounded-full bg-fluent-blue flex items-center justify-center text-white font-semibold text-sm shrink-0">JD</div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-fluent-text">John Doe</p>
                                <p class="text-xs text-fluent-secondary mt-0.5">Computer Science • 10:00 AM</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fluent-success/10 text-fluent-success">Present</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-fluent-bg transition-colors cursor-pointer">
                            <div class="w-10 h-10 rounded-full bg-fluent-success flex items-center justify-center text-white font-semibold text-sm shrink-0">JS</div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-fluent-text">Jane Smith</p>
                                <p class="text-xs text-fluent-secondary mt-0.5">Mathematics • 12:00 PM</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fluent-warning/10 text-fluent-warning">Late</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-fluent-bg transition-colors cursor-pointer">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-semibold text-sm shrink-0">MJ</div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-fluent-text">Mike Johnson</p>
                                <p class="text-xs text-fluent-secondary mt-0.5">Physics • 2:00 PM</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fluent-error/10 text-fluent-error">Absent</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 border border-fluent-border">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-fluent-text">Upcoming Classes</h3>
                        <a href="#" class="text-sm text-fluent-blue hover:text-fluent-darkBlue font-medium transition-colors flex items-center gap-1">
                            Full Timetable
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-fluent-bg transition-colors cursor-pointer border-l-4 border-fluent-success">
                            <div class="flex flex-col items-center min-w-[60px] bg-fluent-bg px-3 py-2 rounded-lg">
                                <span class="text-base font-bold text-fluent-text">10:00</span>
                                <span class="text-[10px] text-fluent-secondary font-semibold uppercase">AM</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-fluent-text">Computer Science</p>
                                <p class="text-xs text-fluent-secondary mt-0.5">ICT Center • Room 101</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fluent-success/10 text-fluent-success">Ongoing</span>
                        </div>
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-fluent-bg transition-colors cursor-pointer border-l-4 border-fluent-blue">
                            <div class="flex flex-col items-center min-w-[60px] bg-fluent-bg px-3 py-2 rounded-lg">
                                <span class="text-base font-bold text-fluent-text">12:00</span>
                                <span class="text-[10px] text-fluent-secondary font-semibold uppercase">PM</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-fluent-text">Mathematics</p>
                                <p class="text-xs text-fluent-secondary mt-0.5">Main Building • Room 204</p>
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fluent-blue/10 text-fluent-blue">In 30 min</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        @include('inc.quick_access')
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', system-ui, -apple-system, sans-serif";

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                if (loader) {
                    loader.classList.add('hidden');
                    setTimeout(() => loader.remove(), 200);
                }
            }, 200);
            initAttendanceChart();
            initDepartmentChart();
        });

        function initAttendanceChart() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    datasets: [{
                        label: 'Present',
                        data: [220, 235, 210, 245, 230],
                        borderColor: '#0078D4',
                        backgroundColor: 'rgba(0, 120, 212, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#0078D4',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }, {
                        label: 'Late',
                        data: [15, 10, 20, 12, 18],
                        borderColor: '#FF8C00',
                        backgroundColor: 'rgba(255, 140, 0, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#FF8C00',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }, {
                        label: 'Absent',
                        data: [8, 5, 15, 6, 12],
                        borderColor: '#D13438',
                        backgroundColor: 'rgba(209, 52, 56, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: '#D13438',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 20, font: { size: 12, weight: '500' } }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function initDepartmentChart() {
            const ctx = document.getElementById('departmentChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Computer Science', 'Engineering', 'Business', 'Mathematics', 'Others'],
                    datasets: [{
                        data: [350, 280, 220, 200, 200],
                        backgroundColor: ['#0078D4', '#107C10', '#FF8C00', '#7C3AED', '#D13438'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 20, font: { size: 12, weight: '500' } }
                        }
                    },
                    cutout: '65%'
                }
            });
        }

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

        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                if (window.innerWidth <= 1024) closeAllSidebars();
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                closeAllSidebars();
                overlay.style.display = 'none';
            }
        });
    </script>
</body>

</html>