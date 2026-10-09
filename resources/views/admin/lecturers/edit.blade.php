{{-- resources/views/admin/lecturers/edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lecturer — DipTek Attendance</title>
    
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
        <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
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
                        <a href="{{ route('lecturers.index') }}" class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Lecturers</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Edit</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Edit Lecturer</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Update {{ $lecturer->name }} information</p>
                </div>
                <a href="{{ route('lecturers.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-card border border-fluent-border p-6 lg:p-8 max-w-2xl">
                <form action="{{ route('lecturers.update', encrypt($lecturer->id)) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Full Name -->
                    <div class="mb-6">
                        <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $lecturer->name) }}" 
                            class="form-input" 
                            placeholder="e.g., Dr. Sarah Smith" 
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $lecturer->email) }}" 
                            class="form-input" 
                            placeholder="e.g., sarah.smith@diptek.edu" 
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $lecturer->phone) }}" 
                            class="form-input" 
                            placeholder="e.g., +234 801 234 5678"
                        >
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Number -->
                    <div class="mb-6">
                        <label for="employee_number" class="form-label">Employee Number <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="employee_number" 
                            name="employee_number" 
                            value="{{ old('employee_number', $lecturer->employee_number) }}" 
                            class="form-input" 
                            placeholder="e.g., EMP-001" 
                            required
                        >
                        @error('employee_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="mb-6">
                        <label for="department_id" class="form-label">Department <span class="text-red-500">*</span></label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $lecturer->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }} ({{ $department->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password (Optional) -->
                    <div class="mb-6">
                        <label for="password" class="form-label">New Password (Optional)</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Leave blank to keep current password"
                        >
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-8">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Re-enter new password"
                        >
                    </div>

                    <!-- Active Status -->
                    <div class="mb-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1" 
                                {{ old('is_active', $lecturer->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-fluent-blue border-fluent-border rounded focus:ring-fluent-blue"
                            >
                            <span class="text-sm font-medium text-fluent-text">Active Lecturer</span>
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3">
                        <button type="submit" class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Update Lecturer
                        </button>
                        <a href="{{ route('lecturers.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
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
    </script>
</body>

</html>