{{-- resources/views/admin/timetables/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Timetable — DipTek Attendance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { fluent: {
                blue: '#0078D4', darkBlue: '#106EBE', lightBlue: '#D0E7F8',
                bg: '#FAF9F8', text: '#1B1A19', secondary: '#605E5C',
                border: '#EDEBE9', success: '#107C10', warning: '#FF8C00', error: '#D13438',
            }}, fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; }
        .btn-sleek { transition: all 0.2s; }
        .btn-sleek:active { transform: scale(0.97); }
        .btn-sleek-primary { background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%); border: 1px solid #106EBE; }
        .btn-sleek-primary:hover { background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%); box-shadow: 0 4px 8px rgba(0,120,212,0.25); }
        .form-input, .form-select, .form-textarea {
            width: 100%; padding: 10px 14px; border: 1px solid #EDEBE9; border-radius: 10px;
            font-size: 14px; color: #1B1A19; background: white; transition: all 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none; border-color: #0078D4; box-shadow: 0 0 0 3px rgba(0,120,212,0.1);
        }
        .form-select {
            appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23605E5C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
        }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #1B1A19; margin-bottom: 6px; }
    </style>
</head>
<body class="bg-fluent-bg font-sans antialiased">
    <div class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">
        @include('inc.sidebar')
        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('timetables.index') }}" class="text-fluent-secondary hover:text-fluent-text">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Timetables</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Add New</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Add Timetable</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Schedule a new lecture session</p>
                </div>
                <a href="{{ route('timetables.index') }}"
                    class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                    Back to List
                </a>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <div class="bg-white rounded-2xl shadow-card border border-fluent-border p-6 lg:p-8 max-w-2xl">
                <form action="{{ route('timetables.store') }}" method="POST">
                    @csrf

                    {{-- Program --}}
                    <div class="mb-6">
                        <label for="program_id" class="form-label">Program <span class="text-red-500">*</span></label>
                        <select id="program_id" name="program_id" class="form-select" required>
                            <option value="">Select Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Course --}}
                    <div class="mb-6">
                        <label for="course_id" class="form-label">Course <span class="text-red-500">*</span></label>
                        <select id="course_id" name="course_id" class="form-select" required>
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lecturer --}}
                    <div class="mb-6">
                        <label for="lecturer_id" class="form-label">Lecturer <span class="text-red-500">*</span></label>
                        <select id="lecturer_id" name="lecturer_id" class="form-select" required>
                            <option value="">Select Lecturer</option>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Location --}}
                    <div class="mb-6">
                        <label for="location_id" class="form-label">Location <span class="text-red-500">*</span></label>
                        <select id="location_id" name="location_id" class="form-select" required>
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }} ({{ $location->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Level --}}
                    <div class="mb-6">
                        <label for="level_id" class="form-label">Level (Optional)</label>
                        <select id="level_id" name="level_id" class="form-select">
                            <option value="">Select Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Day of the Week --}}
                    @php
                        $days = [
                            'monday'    => 'Monday',
                            'tuesday'   => 'Tuesday',
                            'wednesday' => 'Wednesday',
                            'thursday'  => 'Thursday',
                            'friday'    => 'Friday',
                            'saturday'  => 'Saturday',
                            'sunday'    => 'Sunday',
                        ];
                    @endphp
                    <div class="mb-6">
                        <label for="day_of_week" class="form-label">
                            Day of the Week <span class="text-red-500">*</span>
                        </label>
                        <select id="day_of_week" name="day_of_week" class="form-select" required>
                            <option value="">Select Day</option>
                            @foreach ($days as $value => $label)
                                <option value="{{ $value }}" {{ old('day_of_week') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-fluent-secondary mt-1">
                            Pick the day this class holds. The <strong>Start Date</strong> below should fall on the same weekday.
                        </p>
                    </div>

                    {{-- Date --}}
                    <div class="mb-6">
                        <label for="date" class="form-label">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                            class="form-input" required>
                        <p class="text-xs text-fluent-secondary mt-1" id="date-hint"></p>
                    </div>

                    {{-- Time Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="start_time" class="form-label">Start Time <span class="text-red-500">*</span></label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                                class="form-input" required>
                        </div>
                        <div>
                            <label for="end_time" class="form-label">End Time <span class="text-red-500">*</span></label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                                class="form-input" required>
                        </div>
                    </div>

                    {{-- Attendance Window --}}
                    <div class="mb-6">
                        <label for="attendance_window_minutes" class="form-label">Attendance Window (minutes)</label>
                        <input type="number" id="attendance_window_minutes" name="attendance_window_minutes"
                            value="{{ old('attendance_window_minutes', 15) }}" class="form-input" min="1" max="120">
                        <p class="text-xs text-fluent-secondary mt-1">How long students can mark attendance after class starts</p>
                    </div>

                    {{-- Status --}}
                    <div class="mb-6">
                        <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    {{-- Cancel Reason --}}
                    <div class="mb-8">
                        <label for="cancel_reason" class="form-label">Cancel Reason (Optional)</label>
                        <textarea id="cancel_reason" name="cancel_reason" rows="3" class="form-input"
                            placeholder="Reason for cancellation...">{{ old('cancel_reason') }}</textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3">
                        <button type="submit"
                            class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Save Timetable
                        </button>
                        <a href="{{ route('timetables.index') }}"
                            class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
        @include('inc.quick_access')
    </div>

    <script>
        // Hint: warn if Start Date's weekday doesn't match the selected Day of the Week
        (function () {
            const dateInput = document.getElementById('date');
            const daySelect = document.getElementById('day_of_week');
            const hint      = document.getElementById('date-hint');

            const dayNames = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            const pretty   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

            function syncHint() {
                if (!dateInput.value) { hint.textContent = ''; return; }
                const d = new Date(dateInput.value + 'T00:00:00');
                if (isNaN(d)) { hint.textContent = ''; return; }

                const name  = dayNames[d.getDay()];
                const label = pretty[d.getDay()];

                // Auto-select the matching day if nothing is selected yet
                if (!daySelect.value) {
                    daySelect.value = name;
                    hint.classList.remove('text-fluent-error');
                    hint.classList.add('text-fluent-secondary');
                    hint.textContent = `Auto-selected ${label} to match the start date.`;
                    return;
                }

                if (daySelect.value !== name) {
                    hint.classList.add('text-fluent-error');
                    hint.classList.remove('text-fluent-secondary');
                    hint.textContent = `⚠ Start date falls on a ${label}, but you selected ${pretty[dayNames.indexOf(daySelect.value)]}.`;
                } else {
                    hint.classList.remove('text-fluent-error');
                    hint.classList.add('text-fluent-secondary');
                    hint.textContent = `Start date matches ${label}.`;
                }
            }

            dateInput.addEventListener('change', syncHint);
            daySelect.addEventListener('change', syncHint);
            syncHint();
        })();
    </script>
</body>
</html>