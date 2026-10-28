{{-- resources/views/inc/quick_access.blade.php --}}
<aside class="sidebar-right bg-[#0a0e17] text-[#e2e8f0] flex flex-col h-screen overflow-y-auto overflow-x-hidden border-l border-white/5 max-lg:fixed max-lg:right-0 max-lg:top-0 max-lg:bottom-0 max-lg:w-[320px] max-lg:z-[90] max-lg:translate-x-full max-lg:transition-transform max-lg:duration-300 max-lg:invisible"
    id="sidebarRight">

    <div class="px-5 py-4 border-b border-white/5">
        <h2 class="text-sm font-semibold tracking-tight">Upcoming Events</h2>
        <p class="text-[11px] text-slate-500 mt-1">School calendar</p>
    </div>

    <div class="p-4 flex-1 space-y-2">

        {{-- Today --}}
        <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 px-2 pt-1">Today</div>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">Staff General Meeting</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">09:00 · Main Hall</div>
                </div>
                <span class="text-[10px] font-semibold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full shrink-0">Today</span>
            </div>
        </a>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">CS Practical Session</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">14:00 · ICT Center</div>
                </div>
                <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full shrink-0">Live</span>
            </div>
        </a>

        {{-- This week --}}
        <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 px-2 pt-3">This week</div>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">Mid-Semester Examinations</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">Wed · Starts 08:00</div>
                </div>
                <span class="text-[10px] font-semibold text-slate-400 bg-white/5 px-2 py-0.5 rounded-full shrink-0">Wed</span>
            </div>
        </a>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">Faculty Board Review</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">Thu · 10:00 · Boardroom</div>
                </div>
                <span class="text-[10px] font-semibold text-slate-400 bg-white/5 px-2 py-0.5 rounded-full shrink-0">Thu</span>
            </div>
        </a>

        {{-- Next week --}}
        <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 px-2 pt-3">Next week</div>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">Inter-Departmental Sports</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">Mon · Sports Complex</div>
                </div>
                <span class="text-[10px] font-semibold text-slate-400 bg-white/5 px-2 py-0.5 rounded-full shrink-0">Mon</span>
            </div>
        </a>

        <a href="#" class="block bg-white/[0.03] border border-white/5 rounded-xl p-3 hover:bg-white/[0.06] transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">Project Defence — Final Year</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">Fri · 09:00 · Auditorium</div>
                </div>
                <span class="text-[10px] font-semibold text-slate-400 bg-white/5 px-2 py-0.5 rounded-full shrink-0">Fri</span>
            </div>
        </a>

    </div>

    <div class="p-4 border-t border-white/5">
        <a href="#" class="block text-center text-[11px] font-semibold text-slate-400 hover:text-white transition-colors py-2">
            View full calendar
        </a>
    </div>
</aside>