<aside class="sidebar-right bg-[#0a0e17] text-[#e2e8f0] flex flex-col h-screen overflow-y-auto overflow-x-hidden border-l border-white/5 max-lg:fixed max-lg:right-0 max-lg:top-0 max-lg:bottom-0 max-lg:w-[320px] max-lg:z-[90] max-lg:translate-x-full max-lg:transition-transform max-lg:duration-300 max-lg:invisible" id="sidebarRight">
    <!-- Header -->
    <div class="px-5 py-5 border-b border-white/5">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold tracking-tight">Quick Access</h2>
            <button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="p-4 flex-1 space-y-3">
        
        <!-- Today's Classes -->
        <div class="bg-white/[0.03] border border-white/5 rounded-2xl p-4 hover:bg-white/[0.05] transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="flex items-center gap-2 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Today's Classes
                </h3>
                <span class="text-[10px] font-semibold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full">3 Classes</span>
            </div>
            
            <div class="space-y-1">
                <div class="flex items-center justify-between py-2.5 px-2 rounded-xl hover:bg-white/5 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 text-white text-[11px] font-bold rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">CS</div>
                        <div>
                            <div class="text-xs font-semibold group-hover:text-white transition-colors">Computer Science</div>
                            <div class="text-[10px] text-slate-500">10:00 AM - ICT Center</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-400 flex items-center gap-1.5 bg-emerald-500/10 px-2 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        Live
                    </span>
                </div>
                
                <div class="flex items-center justify-between py-2.5 px-2 rounded-xl hover:bg-white/5 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-green-500 to-green-600 text-white text-[11px] font-bold rounded-lg flex items-center justify-center shadow-lg shadow-green-500/20">MT</div>
                        <div>
                            <div class="text-xs font-semibold group-hover:text-white transition-colors">Mathematics</div>
                            <div class="text-[10px] text-slate-500">12:00 PM - Room 204</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-amber-400">In 30 min</span>
                </div>
                
                <div class="flex items-center justify-between py-2.5 px-2 rounded-xl hover:bg-white/5 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-purple-600 text-white text-[11px] font-bold rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/20">PH</div>
                        <div>
                            <div class="text-xs font-semibold group-hover:text-white transition-colors">Physics</div>
                            <div class="text-[10px] text-slate-500">2:00 PM - Lab 3</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-amber-400">In 2 hrs</span>
                </div>
            </div>
        </div>

        <!-- Attendance Overview -->
        <div class="bg-white/[0.03] border border-white/5 rounded-2xl p-4 hover:bg-white/[0.05] transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="flex items-center gap-2 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    Attendance
                </h3>
                <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full">92%</span>
            </div>
            
            <div class="space-y-1">
                <div class="flex items-center justify-between py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full shadow-[0_0_8px_#34d399]"></span>
                        <div>
                            <div class="text-xs font-semibold">Present</div>
                            <div class="text-[10px] text-slate-500">On time</div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-emerald-400">245</span>
                </div>
                
                <div class="flex items-center justify-between py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 bg-amber-400 rounded-full shadow-[0_0_8px_#fbbf24]"></span>
                        <div>
                            <div class="text-xs font-semibold">Late</div>
                            <div class="text-[10px] text-slate-500">After grace</div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-amber-400">18</span>
                </div>
                
                <div class="flex items-center justify-between py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 bg-red-500 rounded-full shadow-[0_0_8px_#ef4444]"></span>
                        <div>
                            <div class="text-xs font-semibold">Absent</div>
                            <div class="text-[10px] text-slate-500">Not checked in</div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-red-500">12</span>
                </div>
                
                <div class="flex items-center justify-between py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 bg-blue-400 rounded-full shadow-[0_0_8px_#60a5fa]"></span>
                        <div>
                            <div class="text-xs font-semibold">Excused</div>
                            <div class="text-[10px] text-slate-500">With permission</div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-blue-400">5</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white/[0.03] border border-white/5 rounded-2xl p-4 hover:bg-white/[0.05] transition-all duration-200">
            <h3 class="flex items-center gap-2 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Recent Activity
            </h3>
            
            <div class="space-y-1">
                <div class="flex gap-3 py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mt-1.5 shadow-[0_0_8px_#34d399] shrink-0"></span>
                    <div class="flex-1">
                        <div class="text-[11px] leading-relaxed">John Doe clocked in for <strong class="text-emerald-400 font-semibold">Computer Science</strong></div>
                        <div class="text-[10px] text-slate-500 mt-0.5">2 min ago</div>
                    </div>
                </div>
                
                <div class="flex gap-3 py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mt-1.5 shadow-[0_0_8px_#60a5fa] shrink-0"></span>
                    <div class="flex-1">
                        <div class="text-[11px] leading-relaxed">New timetable added: <strong class="font-semibold">Physics Lab</strong></div>
                        <div class="text-[10px] text-slate-500 mt-0.5">15 min ago</div>
                    </div>
                </div>
                
                <div class="flex gap-3 py-2 px-2 rounded-lg hover:bg-white/5 transition-colors cursor-pointer">
                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full mt-1.5 shadow-[0_0_8px_#fbbf24] shrink-0"></span>
                    <div class="flex-1">
                        <div class="text-[11px] leading-relaxed">Jane Smith marked <strong class="text-amber-400 font-semibold">late</strong> for Mathematics</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">25 min ago</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white/[0.03] border border-white/5 rounded-2xl p-4">
            <h3 class="flex items-center gap-2 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                </svg>
                Quick Actions
            </h3>
            
            <div class="grid grid-cols-2 gap-2">
                <button class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-[11px] font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-500/30 active:translate-y-0 transition-all duration-200 cursor-pointer border-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <line x1="19" y1="8" x2="19" y2="14" />
                        <line x1="22" y1="11" x2="16" y2="11" />
                    </svg>
                    Add Student
                </button>
                
                <button class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-[11px] font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-green-500/30 active:translate-y-0 transition-all duration-200 cursor-pointer border-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Timetable
                </button>
                
                <button class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-[11px] font-semibold text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-purple-500/30 active:translate-y-0 transition-all duration-200 cursor-pointer border-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    Location
                </button>
                
                <button class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-[11px] font-semibold text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/30 active:translate-y-0 transition-all duration-200 cursor-pointer border-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Report
                </button>
            </div>
        </div>
    </div>
</aside>