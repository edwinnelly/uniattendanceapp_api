<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DipTek') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#111111',
                        paper: '#ffffff',
                        muted: '#6b7280',
                        line: '#e5e7eb',
                        brand: '#14532d',
                        brandSoft: '#dcfce7',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-paper text-ink font-sans antialiased">

    <header class="border-b border-line">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="w-8 h-8 rounded bg-brand flex items-center justify-center text-white text-sm font-bold">D</span>
                <span class="font-semibold text-base tracking-tight">DipTek</span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded border border-line hover:border-ink transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-muted hover:text-ink transition-colors">
                            Sign in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded bg-ink text-white hover:bg-black transition-colors">
                                Get started
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="max-w-6xl mx-auto px-6 pt-16 pb-20">
            <div class="max-w-2xl">
                <p class="text-xs font-medium text-brand uppercase tracking-wider mb-4">School attendance &amp; security</p>
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight leading-tight mb-5">
                    Know who's on campus, and what's happening.
                </h1>
                <p class="text-base text-muted leading-relaxed mb-8 max-w-xl">
                    DipTek gives your school a single place to clock students in and out,
                    see who's where during the day, and log incidents before they become
                    problems. Students clock in with whatever they already carry —
                    their phone, a wristband, or a smart card. And when someone asks
                    for a report, you print it in one click. No badges to chase.
                    No paperwork to file.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                       class="inline-flex items-center justify-center px-5 py-3 rounded bg-brand text-white text-sm font-medium hover:bg-green-900 transition-colors">
                        Create an account
                    </a>
                    <a href="{{ Route::has('login') ? route('login') : '#' }}"
                       class="inline-flex items-center justify-center px-5 py-3 rounded border border-line text-sm font-medium hover:border-ink transition-colors">
                        Sign in
                    </a>
                </div>
                <p class="text-xs text-muted mt-5">
                    Works on the phones your students already own. No new hardware required to start.
                </p>
            </div>
        </section>

        {{-- How students clock in --}}
        <section class="border-t border-line bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-sm font-semibold text-muted uppercase tracking-wider mb-3">Three ways to clock in</h2>
                <p class="text-base text-muted leading-relaxed mb-10 max-w-2xl">
                    Schools don't all work the same way, so DipTek doesn't force a single
                    method. Use one, use all three, or mix them by year group.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Phone --}}
                    <div class="bg-white rounded border border-line p-6">
                        <div class="w-10 h-10 rounded bg-brandSoft text-brand flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="6" y="2" width="12" height="20" rx="2"/>
                                <line x1="11" y1="18" x2="13" y2="18"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">On their phone</h3>
                        <p class="text-sm text-muted leading-relaxed mb-3">
                            Every student already has a phone. They open the DipTek
                            student page, tap "Clock in," and their location and time
                            are recorded. The whole thing takes about four seconds.
                        </p>
                        <p class="text-xs text-muted leading-relaxed">
                            Works on any phone with a browser. No app store download,
                            no permission prompts, no QR code to scan at the gate.
                        </p>
                    </div>

                    {{-- Wristband --}}
                    <div class="bg-white rounded border border-line p-6">
                        <div class="w-10 h-10 rounded bg-brandSoft text-brand flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="7" y="3" width="10" height="18" rx="3"/>
                                <circle cx="12" cy="12" r="2"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">With a wristband</h3>
                        <p class="text-sm text-muted leading-relaxed mb-3">
                            A small RFID wristband taps against a reader at the gate
                            or at the door to each classroom. Students who forget their
                            phone still clock in.
                        </p>
                        <p class="text-xs text-muted leading-relaxed">
                            Useful for younger students or for any school that would
                            rather not depend on phones during the day.
                        </p>
                    </div>

                    {{-- Smart card --}}
                    <div class="bg-white rounded border border-line p-6">
                        <div class="w-10 h-10 rounded bg-brandSoft text-brand flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="6" width="20" height="13" rx="2"/>
                                <line x1="2" y1="10" x2="22" y2="10"/>
                                <line x1="6" y1="15" x2="10" y2="15"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">With a smart card</h3>
                        <p class="text-sm text-muted leading-relaxed mb-3">
                            The same card students already use for the library or the
                            cafeteria can double as their attendance card. One tap at
                            the reader, one record.
                        </p>
                        <p class="text-xs text-muted leading-relaxed">
                            If your school already issues ID cards, we can often wire
                            DipTek into the ones you have.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- What you can do --}}
        <section class="border-t border-line">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-sm font-semibold text-muted uppercase tracking-wider mb-10">What you can do</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div>
                        <div class="w-10 h-10 rounded border border-line flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <polyline points="12 7 12 12 15 14"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">Clock in and out</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Students clock in when they arrive and out when they leave.
                            Every entry is timestamped with the method used.
                        </p>
                    </div>

                    <div>
                        <div class="w-10 h-10 rounded border border-line flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">See where everyone is</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            A live view of the school: who's in class, who's at the
                            library, who left early. Filter by class or time of day.
                        </p>
                    </div>

                    <div>
                        <div class="w-10 h-10 rounded border border-line flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2 4 6v6c0 5 3.5 9 8 10 4.5-1 8-5 8-10V6l-8-4z"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12" y2="16"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">Report violations</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Staff can log an incident against a student in seconds —
                            late arrivals, leaving campus, or anything else you want
                            on record. Each report carries a time and a place.
                        </p>
                    </div>

                    <div>
                        <div class="w-10 h-10 rounded border border-line flex items-center justify-center mb-4">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                <rect x="6" y="14" width="12" height="8"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base mb-2">Print attendance</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Pick a class, a date range, or a single student. Print a
                            clean page straight from the browser, or save it as a PDF.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Print attendance --}}
        <section class="border-t border-line bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                    <div>
                        <h2 class="text-sm font-semibold text-muted uppercase tracking-wider mb-4">Printing attendance</h2>
                        <h3 class="text-2xl font-bold tracking-tight mb-4">
                            A printable attendance sheet in two clicks.
                        </h3>
                        <p class="text-sm text-muted leading-relaxed mb-4">
                            When a parent, a board member, or an inspector asks for
                            the attendance record, you don't need to open a spreadsheet.
                            Pick a class and a date range, then either print the page
                            directly from the browser or save it as a PDF.
                        </p>
                        <p class="text-sm text-muted leading-relaxed mb-4">
                            The printed sheet carries the school's name, the class,
                            the date range, and a signature line at the bottom — so
                            it's ready to hand over without further editing.
                        </p>
                        <ul class="text-sm text-muted leading-relaxed space-y-2 mt-6">
                            <li class="flex gap-2">
                                <span class="text-brand">—</span>
                                Print by class, by department, by date range, or by individual student
                            </li>
                            <li class="flex gap-2">
                                <span class="text-brand">—</span>
                                Include the clock-in method beside each record if you want it
                            </li>
                            <li class="flex gap-2">
                                <span class="text-brand">—</span>
                                Save the same page as a PDF for email or archive
                            </li>
                            <li class="flex gap-2">
                                <span class="text-brand">—</span>
                                Layout adjusts to fit either A4 or Letter paper
                            </li>
                        </ul>
                    </div>

                    {{-- Mock printed sheet --}}
                    <div class="bg-white border border-line rounded p-6 font-mono text-xs text-ink">
                        <div class="text-center mb-4 pb-4 border-b border-line">
                            <p class="font-semibold text-sm">Riverside Secondary School</p>
                            <p class="text-muted mt-1">Attendance record · Class 9B</p>
                            <p class="text-muted">1 – 15 March 2026</p>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1 border-b border-line text-muted text-[10px] uppercase">
                            <span>Student</span>
                            <span>In</span>
                            <span>Out</span>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1.5 border-b border-line">
                            <span>Amara Okafor</span>
                            <span>08:02</span>
                            <span>15:31</span>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1.5 border-b border-line">
                            <span>James Mwangi</span>
                            <span>08:14</span>
                            <span>15:28</span>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1.5 border-b border-line">
                            <span>Fatima Bello</span>
                            <span>08:07</span>
                            <span>15:30</span>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1.5 border-b border-line">
                            <span>Daniel Osei</span>
                            <span>—</span>
                            <span>—</span>
                        </div>
                        <div class="grid grid-cols-[1fr_60px_60px] gap-2 py-1.5">
                            <span>Grace Njeri</span>
                            <span>08:21</span>
                            <span>15:25</span>
                        </div>
                        <div class="mt-6 pt-4 border-t border-line text-muted text-[10px] flex justify-between">
                            <span>Signed: ____________________</span>
                            <span>Page 1 of 1</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- What admins actually see --}}
        <section class="border-t border-line">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                    <div>
                        <h2 class="text-sm font-semibold text-muted uppercase tracking-wider mb-4">On the admin side</h2>
                        <h3 class="text-2xl font-bold tracking-tight mb-4">
                            A record of the school day, in the order it happened.
                        </h3>
                        <p class="text-sm text-muted leading-relaxed mb-4">
                            Every clock-in, clock-out, and incident report lands in the
                            same timeline. Filter it by student, class, gate, or date.
                            Export it at the end of the term if your board asks for it.
                        </p>
                        <p class="text-sm text-muted leading-relaxed">
                            Nothing about the workflow assumes staff are sitting at a
                            desk. Reports can be filed from a phone in the corridor
                            and are visible on the dashboard immediately.
                        </p>
                    </div>

                    <div class="border border-line rounded divide-y divide-line text-sm">
                        <div class="flex items-start gap-3 p-4">
                            <span class="text-xs text-muted w-14 shrink-0 tabular-nums pt-0.5">08:04</span>
                            <div class="flex-1">
                                <p class="font-medium">Clocked in</p>
                                <p class="text-xs text-muted mt-0.5">Phone · Main gate</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4">
                            <span class="text-xs text-muted w-14 shrink-0 tabular-nums pt-0.5">09:12</span>
                            <div class="flex-1">
                                <p class="font-medium">Marked late</p>
                                <p class="text-xs text-muted mt-0.5">Wristband · Room B12</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4">
                            <span class="text-xs text-muted w-14 shrink-0 tabular-nums pt-0.5">11:40</span>
                            <div class="flex-1">
                                <p class="font-medium">Report filed</p>
                                <p class="text-xs text-muted mt-0.5">Left campus without permission</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4">
                            <span class="text-xs text-muted w-14 shrink-0 tabular-nums pt-0.5">15:31</span>
                            <div class="flex-1">
                                <p class="font-medium">Clocked out</p>
                                <p class="text-xs text-muted mt-0.5">Smart card · Main gate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Why schools use it --}}
        <section class="border-t border-line bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-sm font-semibold text-muted uppercase tracking-wider mb-3">Why schools use DipTek</h2>
                <p class="text-base text-muted leading-relaxed mb-10 max-w-2xl">
                    Attendance and safety, without the daily friction. Here's what
                    schools actually tell us they get out of it.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div>
                        <h3 class="font-semibold text-base mb-2">Less time on admin</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            No more calling names in the morning or collecting paper
                            registers from every classroom. Teachers see who's present
                            before the lesson starts.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-base mb-2">Fewer unaccounted gaps</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            If a student doesn't clock in by the time school starts,
                            the dashboard flags it. That's the difference between a
                            parent being called at 8:30 or at lunchtime.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-base mb-2">One place for everything</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Attendance, incident reports, and student records live in
                            the same system. No more digging through a filing cabinet
                            or three different spreadsheets to find one name.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-base mb-2">A clear record for parents</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            When a parent asks about their child's attendance, you
                            pull up the printed sheet — every entry, every method,
                            every timestamp, signed at the bottom.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-base mb-2">Easier inspections</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Board reviews, ministry inspections, and term reports all
                            ask for the same thing: an attendance record. Export it
                            in a minute instead of an afternoon.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-base mb-2">No new hardware to start</h3>
                        <p class="text-sm text-muted leading-relaxed">
                            Roll out with phones only, which every student already
                            has. Add wristbands or smart cards later, one year group
                            at a time, if you decide you want them.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How a school day runs --}}
        <section class="border-t border-line bg-ink text-white">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-sm font-semibold uppercase tracking-wider mb-10 opacity-60">How a school day runs</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <p class="text-3xl font-bold mb-2 opacity-30">01</p>
                        <h3 class="font-semibold text-base mb-1">Arrival</h3>
                        <p class="text-sm leading-relaxed opacity-70">
                            Students clock in at the gate by phone, wristband, or card.
                            Their status updates the moment they pass through.
                        </p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold mb-2 opacity-30">02</p>
                        <h3 class="font-semibold text-base mb-1">Throughout the day</h3>
                        <p class="text-sm leading-relaxed opacity-70">
                            Attendance is tracked per class. Late arrivals are flagged
                            automatically, and the record shows how they got in.
                        </p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold mb-2 opacity-30">03</p>
                        <h3 class="font-semibold text-base mb-1">Incidents</h3>
                        <p class="text-sm leading-relaxed opacity-70">
                            Any staff member can file a report from their phone. It goes
                            to the admin dashboard, not a shared inbox.
                        </p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold mb-2 opacity-30">04</p>
                        <h3 class="font-semibold text-base mb-1">End of day</h3>
                        <p class="text-sm leading-relaxed opacity-70">
                            See who left, who stayed back, and every incident logged.
                            Print the day's sheet or export the term's records.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Closing CTA --}}
        <section class="border-t border-line">
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight mb-2">Ready to get set up?</h2>
                        <p class="text-sm text-muted">Accounts are free for schools. Bring your roster and you're running the same day.</p>
                    </div>
                    <div class="flex gap-3 shrink-0">
                        <a href="{{ Route::has('register') ? route('register') : '#' }}"
                           class="inline-flex items-center justify-center px-5 py-2.5 rounded bg-brand text-white text-sm font-medium hover:bg-green-900 transition-colors">
                            Create account
                        </a>
                        <a href="mailto:hello@diptek.app"
                           class="inline-flex items-center justify-center px-5 py-2.5 rounded border border-line text-sm font-medium hover:border-ink transition-colors">
                            Contact us
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-line">
        <div class="max-w-6xl mx-auto px-6 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-muted">
            <p>&copy; {{ date('Y') }} DipTek. All rights reserved.</p>
            <p>
                <a href="#" class="hover:text-ink">Privacy</a>
                <span class="mx-2">·</span>
                <a href="#" class="hover:text-ink">Terms</a>
                <span class="mx-2">·</span>
                <a href="mailto:hello@diptek.app" class="hover:text-ink">hello@diptek.app</a>
            </p>
        </div>
    </footer>

</body>
</html>