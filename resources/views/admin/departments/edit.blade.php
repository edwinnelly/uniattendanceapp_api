{{-- resources/views/admin/departments/edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department — DipTek Attendance</title>
    
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
                        card: '0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04)',
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
        
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .btn-sleek {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-sleek:active {
            transform: scale(0.97);
        }
        .btn-sleek-primary {
            background: linear-gradient(180deg, #0078D4 0%, #106EBE 100%);
            border: 1px solid #106EBE;
        }
        .btn-sleek-primary:hover {
            background: linear-gradient(180deg, #106EBE 0%, #0F5E9E 100%);
            box-shadow: 0 4px 8px rgba(0,120,212,0.25);
        }
        
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #EDEBE9;
            border-radius: 10px;
            font-size: 14px;
            color: #1B1A19;
            background: white;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #0078D4;
            box-shadow: 0 0 0 3px rgba(0,120,212,0.1);
        }
        
        .form-input.error {
            border-color: #D13438;
        }
        
        .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #EDEBE9;
            border-radius: 10px;
            font-size: 14px;
            color: #1B1A19;
            background: white;
            transition: all 0.2s;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23605E5C' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #0078D4;
            box-shadow: 0 0 0 3px rgba(0,120,212,0.1);
        }
        
        .form-select.error {
            border-color: #D13438;
        }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1B1A19;
            margin-bottom: 6px;
        }
        
        @media (max-width: 1024px) {
            .sidebar-left {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                width: 280px !important;
                z-index: 90;
                transform: translateX(-100%);
                transition: transform 0.3s;
                visibility: hidden;
            }
            .sidebar-left.open {
                transform: translateX(0);
                visibility: visible;
            }
            .sidebar-right {
                position: fixed;
                right: 0;
                top: 0;
                bottom: 0;
                width: 320px !important;
                z-index: 90;
                transform: translateX(100%);
                transition: transform 0.3s;
                visibility: hidden;
            }
            .sidebar-right.open {
                transform: translateX(0);
                visibility: visible;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 89;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-fluent-bg font-sans antialiased">

    <!-- Page Loader -->
    <div id="pageLoader" class="fixed inset-0 bg-white z-[999] flex items-center justify-center flex-col gap-5 transition-opacity duration-300">
        <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-2xl animate-bounce">
            <img src="{{ asset('logo/logo.png') }}" alt="DipTek Logo" class="w-8 h-8">
        </div>
        <div class="text-center">
            <div class="font-bold text-lg text-gray-800 uppercase tracking-wider">DipTek</div>
            <div class="text-xs text-gray-500 mt-1">Loading...</div>
        </div>
    </div>

    <!-- Mobile Toggles -->
    <button class="lg:hidden fixed top-3.5 left-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 cursor-pointer flex items-center justify-center text-fluent-text shadow-lg" id="mobileToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.5" /><circle cx="12" cy="12" r="1.5" /><circle cx="19" cy="12" r="1.5" /></svg>
    </button>

    <button class="lg:hidden fixed top-3.5 right-3.5 z-[100] w-[38px] h-[38px] rounded-full border border-fluent-border bg-white/90 cursor-pointer flex items-center justify-center text-fluent-text shadow-lg" id="mobileRightToggle">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9" /><polyline points="12 7 12 12 15 14" /></svg>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="fullpage grid grid-cols-[260px_1fr_340px] min-h-screen max-[1400px]:grid-cols-[220px_1fr_300px] max-[1024px]:grid-cols-1">

        <!-- Left Sidebar -->
        @include('inc.sidebar')

        <!-- Main Content -->
        <main class="main-content p-6 lg:p-7 overflow-y-auto h-screen">

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('admin.departments.index') }}" class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Departments</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Edit</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Edit Department</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Update {{ $department->name }} information</p>
                </div>
                <a href="{{ route('admin.departments.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-start gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <div class="flex items-start gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-card border border-fluent-border p-6 lg:p-8 max-w-2xl">
                <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Department Name -->
                    <div class="mb-6">
                        <label for="name" class="form-label">Department Name <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $department->name) }}" 
                            class="form-input @error('name') error @enderror" 
                            placeholder="e.g., Computer Science" 
                            maxlength="150"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department Code -->
                    <div class="mb-6">
                        <label for="code" class="form-label">Department Code <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code', $department->code) }}" 
                            class="form-input @error('code') error @enderror" 
                            placeholder="e.g., CS" 
                            maxlength="20"
                            required
                        >
                        <p class="text-xs text-fluent-secondary mt-1">Maximum 20 characters, must be unique</p>
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Faculty Dropdown (NEW) -->
                    <div class="mb-6">
                        <label for="faculty_id" class="form-label">Faculty</label>
                        <select id="faculty_id" name="faculty_id" class="form-select @error('faculty_id') error @enderror">
                            <option value="">Select Faculty</option>
                            @foreach($faculties ?? [] as $faculty)
                                <option value="{{ $faculty->id }}" {{ old('faculty_id', $department->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-fluent-secondary mt-1">Optional — assign department to a faculty</p>
                        @error('faculty_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department Head Dropdown -->
                    <div class="mb-6">
                        <label for="head_id" class="form-label">Department Head</label>
                        <select id="head_id" name="head_id" class="form-select @error('head_id') error @enderror">
                            <option value="">Select Department Head</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ old('head_id', $department->head_id) == $lecturer->id ? 'selected' : '' }}>
                                    {{ $lecturer->name }} — {{ $lecturer->email }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-fluent-secondary mt-1">Select from available lecturers</p>
                        @error('head_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration Years (NEW) -->
                    <div class="mb-6">
                        <label for="duration_years" class="form-label">Duration (Years) <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            id="duration_years" 
                            name="duration_years" 
                            value="{{ old('duration_years', $department->duration_years ?? 4) }}" 
                            class="form-input @error('duration_years') error @enderror" 
                            placeholder="e.g., 4" 
                            min="1"
                            max="10"
                            required
                        >
                        <p class="text-xs text-fluent-secondary mt-1">Default is 4 years</p>
                        @error('duration_years')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="form-input @error('description') error @enderror" 
                            placeholder="Brief description of the department..."
                            maxlength="1000"
                        >{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1" 
                                {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-fluent-blue border-fluent-border rounded focus:ring-fluent-blue"
                            >
                            <span class="text-sm font-medium text-fluent-text">Active Department</span>
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Update Department
                        </button>
                        <a href="{{ route('admin.departments.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>

        <!-- Right Sidebar -->
        @include('inc.quick_access')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                if (loader) {
                    loader.classList.add('hidden');
                    setTimeout(() => loader.remove(), 200);
                }
            }, 200);
        });

        // Mobile toggle
        const sidebarLeft = document.getElementById('sidebarLeft');
        const sidebarRight = document.getElementById('sidebarRight');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileRightToggle = document.getElementById('mobileRightToggle');

        function closeAllSidebars() {
            sidebarLeft?.classList.remove('open');
            sidebarRight?.classList.remove('open');
            overlay?.classList.remove('active');
            if (overlay) overlay.style.display = 'none';
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

        mobileToggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarLeft?.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarLeft);
        });

        mobileRightToggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebarRight?.classList.contains('open') ? closeAllSidebars() : openSidebar(sidebarRight);
        });

        overlay?.addEventListener('click', closeAllSidebars);
    </script>
</body>

</html>