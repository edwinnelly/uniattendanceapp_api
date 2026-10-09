{{-- resources/views/admin/attendance/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance — DipTek Attendance</title>
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
                        <a href="{{ route('attendance.index') }}" class="text-fluent-secondary hover:text-fluent-text">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Attendance</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Add New</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Add Attendance</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Record a new attendance entry</p>
                </div>
                <a href="{{ route('attendance.index') }}"
                    class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold hover:bg-fluent-bg">
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
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf

                    {{-- Student --}}
                    <div class="mb-6">
                        <label for="student_id" class="form-label">Student <span class="text-red-500">*</span></label>
                        <select id="student_id" name="student_id" class="form-select" required>
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->student_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Timetable --}}
                    <div class="mb-6">
                        <label for="timetable_id" class="form-label">Timetable <span class="text-red-500">*</span></label>
                        <select id="timetable_id" name="timetable_id" class="form-select" required>
                            <option value="">Select Timetable</option>
                            @foreach ($timetables as $timetable)
                                <option value="{{ $timetable->id }}" {{ old('timetable_id') == $timetable->id ? 'selected' : '' }}>
                                    {{ $timetable->course->name ?? 'N/A' }} - {{ $timetable->date ? $timetable->date->format('M d, Y') : '' }} ({{ date('H:i', strtotime($timetable->start_time)) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Clock In --}}
                    <div class="mb-6">
                        <label for="clock_in_time" class="form-label">Clock In Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="clock_in_time" name="clock_in_time"
                            value="{{ old('clock_in_time', now()->format('Y-m-d\TH:i')) }}" class="form-input" required>
                    </div>

                    {{-- Clock Out --}}
                    <div class="mb-6">
                        <label for="clock_out_time" class="form-label">Clock Out Time (Optional)</label>
                        <input type="datetime-local" id="clock_out_time" name="clock_out_time"
                            value="{{ old('clock_out_time') }}" class="form-input">
                    </div>

                    {{-- Coordinates Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="clock_in_latitude" class="form-label">Latitude <span class="text-red-500">*</span></label>
                            <input type="number" step="any" id="clock_in_latitude" name="clock_in_latitude"
                                value="{{ old('clock_in_latitude') }}" class="form-input" placeholder="e.g., 6.4562" required>
                        </div>
                        <div>
                            <label for="clock_in_longitude" class="form-label">Longitude <span class="text-red-500">*</span></label>
                            <input type="number" step="any" id="clock_in_longitude" name="clock_in_longitude"
                                value="{{ old('clock_in_longitude') }}" class="form-input" placeholder="e.g., 3.4562" required>
                        </div>
                    </div>

                    {{-- Accuracy & Distance --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="clock_in_accuracy" class="form-label">Accuracy (meters)</label>
                            <input type="number" step="any" id="clock_in_accuracy" name="clock_in_accuracy"
                                value="{{ old('clock_in_accuracy') }}" class="form-input" placeholder="e.g., 5.5">
                        </div>
                        <div>
                            <label for="distance_meters" class="form-label">Distance (meters)</label>
                            <input type="number" step="any" id="distance_meters" name="distance_meters"
                                value="{{ old('distance_meters') }}" class="form-input" placeholder="e.g., 12.5">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-6">
                        <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="excused" {{ old('status') == 'excused' ? 'selected' : '' }}>Excused</option>
                        </select>
                    </div>

                    {{-- Source --}}
                    <div class="mb-6">
                        <label for="source" class="form-label">Source <span class="text-red-500">*</span></label>
                        <select id="source" name="source" class="form-select" required>
                            <option value="mobile" {{ old('source') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                            <option value="web" {{ old('source') == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="manual" {{ old('source') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="qr_code" {{ old('source') == 'qr_code' ? 'selected' : '' }}>QR Code</option>
                        </select>
                    </div>

                    {{-- Remarks --}}
                    <div class="mb-8">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea id="remarks" name="remarks" rows="3" class="form-textarea"
                            placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3">
                        <button type="submit"
                            class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-sm font-semibold">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Save Attendance
                        </button>
                        <a href="{{ route('attendance.index') }}"
                            class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold hover:bg-fluent-bg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
        @include('inc.quick_access')
    </div>
</body>
</html>