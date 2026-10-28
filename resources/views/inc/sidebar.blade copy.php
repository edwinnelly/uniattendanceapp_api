<aside class="sidebar-left bg-[#0a0e17] text-[#e2e8f0] flex flex-col h-screen overflow-y-auto overflow-x-hidden" id="sidebarLeft">
    <!-- Logo -->
    <div class="px-5 py-6 border-b border-white/5 flex items-center gap-3">
        <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center">
            <img src="{{ asset('logo/logo.png') }}" alt="School Logo" class="w-8 h-8 rounded-lg">
        </div>
        <div class="text-xl font-extrabold tracking-tight">
            <span class="bg-gradient-to-r from-blue-400 to-indigo-900 bg-clip-text text-transparent">Dip</span>Tek
        </div>
    </div>

    <!-- Navigation -->
    <nav class="px-3 py-4 flex-1">
        <!-- Main Menu -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Main Menu</div>
            
            <a href="/dashboard">
                <button class="sidebar-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-semibold text-blue-400 bg-blue-500/10 w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </button>
            </a>
        </div>

        <!-- User Management -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">User Management</div>
            
            <a href="/students">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span>Students</span>
                    <span class="ml-auto bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-xl min-w-5 text-center">0</span>
                </button>
            </a>
            
            <a href="/parents">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <circle cx="17" cy="7" r="4" />
                            <circle cx="7" cy="11" r="3" />
                        </svg>
                    </span>
                    <span>Parents</span>
                    <span class="ml-auto bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-xl min-w-5 text-center">0</span>
                </button>
            </a>
            
            <a href="/lecturers">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                            <path d="M22 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span>Lecturers</span>
                    <span class="ml-auto bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-xl min-w-5 text-center">0</span>
                </button>
            </a>
        </div>

        <!-- Academic Structure -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Academic Structure</div>
            
            
            <a href="/programs">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2" />
                            <polyline points="2 17 12 22 22 17" />
                            <polyline points="2 12 12 17 22 12" />
                        </svg>
                    </span>
                    <span>Faculty</span>
                </button>
            </a>


            <a href="/admin/departments">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="2" width="16" height="20" rx="2" />
                            <line x1="9" y1="2" x2="9" y2="22" />
                            <line x1="15" y1="2" x2="15" y2="22" />
                            <line x1="4" y1="8" x2="20" y2="8" />
                            <line x1="4" y1="16" x2="20" y2="16" />
                        </svg>
                    </span>
                    <span>Departments</span>
                </button>
            </a>
            
           
            
            
            
            <a href="/courses">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                    </span>
                    <span>Courses</span>
                </button>
            </a>

            <a href="/levels">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="19" x2="12" y2="5" />
                            <polyline points="5 12 12 5 19 12" />
                        </svg>
                    </span>
                    <span>Levels</span>
                </button>
            </a>
        </div>

        <!-- Location & Scheduling -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Location & Scheduling</div>
            
            <a href="/lecture-locations">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    <span>Locations</span>
                </button>
            </a>
            
            <a href="#geofence-map">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6" />
                            <line x1="8" y1="2" x2="8" y2="18" />
                            <line x1="16" y1="6" x2="16" y2="22" />
                        </svg>
                    </span>
                    <span>Geofence Map</span>
                </button>
            </a>
            
            <a href="/timetables">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </span>
                    <span>Timetables</span>
                </button>
            </a>
            
            <a href="#calendar">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </span>
                    <span>Events</span>
                </button>
            </a>
        </div>

        <!-- Attendance -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Attendance</div>
            
            <a href="/attendance">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </span>
                    <span>Attendance</span>
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-xl min-w-5 text-center">0</span>
                </button>
            </a>
            
            {{-- <a href="#daily-report">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </span>
                    <span>Daily Report</span>
                </button>
            </a> --}}
            
            <a href="#reports">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                    </span>
                    <span>Reports</span>
                </button>
            </a>
        </div>

        <!-- Analytics -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Analytics</div>
            
            <a href="#statistics">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </span>
                    <span>Statistics</span>
                </button>
            </a>
            
            <a href="#export">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                    </span>
                    <span>Export Data</span>
                </button>
            </a>
        </div>

        <!-- Communication -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">Communication</div>
            
            <a href="#notifications">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                    </span>
                    <span>Notifications</span>
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-xl min-w-5 text-center">0</span>
                </button>
            </a>
            
            <a href="#send-notice">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </span>
                    <span>Send Notice</span>
                </button>
            </a>
        </div>

        <!-- System -->
        <div class="mb-5">
            <div class="text-[10px] uppercase tracking-[2px] text-[#64748b] font-bold px-3 pb-2">System</div>
            
            <a href="#settings">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </span>
                    <span>Settings</span>
                </button>
            </a>
            
            <a href="#geofence-config">
                <button class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#94a3b8] w-full text-left relative hover:bg-white/5 hover:text-white transition-all duration-150">
                    <span class="w-5 h-5 flex items-center justify-center shrink-0 opacity-70">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                    </span>
                    <span>Geofence Config</span>
                </button>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-3 border-t border-white/5">
        <div class="flex items-center gap-2.5 p-2.5 rounded-[10px] cursor-pointer hover:bg-white/5 transition-all duration-150">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-lg">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[13px] font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-[11px] text-[#64748b] capitalize">{{ Auth::user()->user_type ?? 'Administrator' }}</div>
            </div>
            <div class="text-[11px] font-bold text-amber-400 flex items-center gap-1">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10" />
                </svg>0
            </div>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200 bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 hover:text-red-500 hover:border-red-500/40">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Log Out
            </button>
        </form>
    </div>
</aside>