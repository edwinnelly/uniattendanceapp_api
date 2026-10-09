{{-- resources/views/admin/lecture-locations/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lecture Location — DipTek Attendance</title>
    
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
        
        .form-input-error {
            border-color: #D13438;
        }
        .form-input-error:focus {
            border-color: #D13438;
            box-shadow: 0 0 0 3px rgba(209,52,56,0.1);
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
        
        .form-hint {
            font-size: 12px;
            color: #605E5C;
            margin-top: 4px;
        }
        
        .form-error {
            color: #D13438;
            font-size: 12px;
            margin-top: 4px;
        }
        
        .location-preview {
            background: #FAF9F8;
            border: 1px dashed #EDEBE9;
            border-radius: 10px;
            padding: 16px;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Success Animation */
        .success-toast {
            animation: slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
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
                        <a href="{{ route('lecture-locations.index') }}" class="text-fluent-secondary hover:text-fluent-text transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <span class="text-sm text-fluent-secondary">Lecture Locations</span>
                        <span class="text-fluent-secondary">/</span>
                        <span class="text-sm font-semibold text-fluent-text">Add New</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-fluent-text tracking-tight">Add Lecture Location</h1>
                    <p class="text-sm text-fluent-secondary mt-1">Create a new lecture venue or classroom</p>
                </div>
                <a href="{{ route('lecture-locations.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-5 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="success-toast bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#107C10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-green-800">Success!</p>
                        <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700 shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D13438" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-red-800">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm text-red-700 mt-1">
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
                <form action="{{ route('lecture-locations.store') }}" method="POST" id="locationForm">
                    @csrf

                    <!-- Location Name -->
                    <div class="mb-6">
                        <label for="name" class="form-label">Location Name <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            class="form-input @error('name') form-input-error @enderror" 
                            placeholder="e.g., Main Lecture Hall" 
                            required
                        >
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location Code -->
                    <div class="mb-6">
                        <label for="code" class="form-label">Location Code <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code') }}" 
                            class="form-input @error('code') form-input-error @enderror" 
                            placeholder="e.g., MH-101" 
                            maxlength="50"
                            required
                        >
                        <p class="form-hint">Unique code for this location (max 50 characters)</p>
                        @error('code')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Building & Floor & Room Number Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label for="building" class="form-label">Building</label>
                            <input 
                                type="text" 
                                id="building" 
                                name="building" 
                                value="{{ old('building') }}" 
                                class="form-input @error('building') form-input-error @enderror" 
                                placeholder="e.g., Engineering Block"
                            >
                            @error('building')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="floor" class="form-label">Floor</label>
                            <input 
                                type="text" 
                                id="floor" 
                                name="floor" 
                                value="{{ old('floor') }}" 
                                class="form-input @error('floor') form-input-error @enderror" 
                                placeholder="e.g., 3"
                            >
                            @error('floor')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="room_number" class="form-label">Room Number</label>
                            <input 
                                type="text" 
                                id="room_number" 
                                name="room_number" 
                                value="{{ old('room_number') }}" 
                                class="form-input @error('room_number') form-input-error @enderror" 
                                placeholder="e.g., 301"
                            >
                            @error('room_number')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Coordinates Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="latitude" class="form-label">Latitude <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                step="any" 
                                id="latitude" 
                                name="latitude" 
                                value="{{ old('latitude') }}" 
                                class="form-input @error('latitude') form-input-error @enderror" 
                                placeholder="e.g., 6.4562" 
                                required
                            >
                            <p class="form-hint">Between -90 and 90</p>
                            @error('latitude')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitude" class="form-label">Longitude <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                step="any" 
                                id="longitude" 
                                name="longitude" 
                                value="{{ old('longitude') }}" 
                                class="form-input @error('longitude') form-input-error @enderror" 
                                placeholder="e.g., 3.4562" 
                                required
                            >
                            <p class="form-hint">Between -180 and 180</p>
                            @error('longitude')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Map Preview -->
                    <div class="mb-6">
                        <label class="form-label">Location Preview</label>
                        <div id="mapPreview" class="location-preview">
                            <div class="text-center text-fluent-secondary">
                                <svg class="mx-auto mb-2" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <p class="text-sm">Enter coordinates to preview location</p>
                            </div>
                        </div>
                        <p class="form-hint mt-2">
                            <a href="https://www.google.com/maps" target="_blank" class="text-fluent-blue hover:underline">
                                Find coordinates on Google Maps
                            </a>
                        </p>
                    </div>

                    <!-- Radius & Capacity Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="radius_meters" class="form-label">Radius (meters)</label>
                            <input 
                                type="number" 
                                id="radius_meters" 
                                name="radius_meters" 
                                value="{{ old('radius_meters', 50) }}" 
                                class="form-input @error('radius_meters') form-input-error @enderror" 
                                min="1" 
                                max="10000"
                            >
                            <p class="form-hint">Default: 50 meters</p>
                            @error('radius_meters')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="capacity" class="form-label">Capacity (seats)</label>
                            <input 
                                type="number" 
                                id="capacity" 
                                name="capacity" 
                                value="{{ old('capacity') }}" 
                                class="form-input @error('capacity') form-input-error @enderror" 
                                min="1" 
                                max="10000"
                                placeholder="e.g., 100"
                            >
                            <p class="form-hint">Leave empty for unlimited capacity</p>
                            @error('capacity')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-8">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1" 
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-4 h-4 text-fluent-blue border-fluent-border rounded focus:ring-fluent-blue"
                            >
                            <span class="text-sm font-medium text-fluent-text">Active Location</span>
                        </label>
                        <p class="form-hint ml-7">Inactive locations won't appear in scheduling options</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="btn-sleek btn-sleek-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-white rounded-xl text-sm font-semibold tracking-wide">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Create Location
                        </button>
                        <a href="{{ route('lecture-locations.index') }}" class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-text bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                            Cancel
                        </a>
                        <button type="reset" class="btn-sleek inline-flex items-center justify-center gap-2 px-6 py-3 text-fluent-secondary bg-white border border-fluent-border rounded-xl text-sm font-semibold tracking-wide hover:bg-fluent-bg">
                            Reset Form
                        </button>
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

            // Auto-hide success message after 5 seconds
            const successToast = document.querySelector('.success-toast');
            if (successToast) {
                setTimeout(function() {
                    successToast.style.transition = 'opacity 0.5s';
                    successToast.style.opacity = '0';
                    setTimeout(() => successToast.remove(), 500);
                }, 5000);
            }

            // Real-time map preview
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const mapPreview = document.getElementById('mapPreview');

            function updateMapPreview() {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                
                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    const mapUrl = `https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=${lat},${lng}&zoom=15`;
                    mapPreview.innerHTML = `
                        <div class="w-full h-full min-h-[100px] flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-sm font-semibold text-fluent-text">📍 Location Found</div>
                                <div class="text-xs text-fluent-secondary mt-1">${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                                <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" 
                                   class="text-xs text-fluent-blue hover:underline mt-2 inline-block">
                                    View on Google Maps →
                                </a>
                            </div>
                        </div>
                    `;
                } else {
                    mapPreview.innerHTML = `
                        <div class="text-center text-fluent-secondary">
                            <svg class="mx-auto mb-2" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <p class="text-sm">Enter valid coordinates to preview</p>
                        </div>
                    `;
                }
            }

            latInput.addEventListener('input', updateMapPreview);
            lngInput.addEventListener('input', updateMapPreview);

            // Auto-generate code from name (optional helper)
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');

            nameInput.addEventListener('blur', function() {
                if (codeInput.value === '' && nameInput.value !== '') {
                    // Generate a code from the name
                    let code = nameInput.value
                        .toUpperCase()
                        .replace(/[^A-Z0-9]/g, '')
                        .substring(0, 10);
                    codeInput.value = code;
                }
            });
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