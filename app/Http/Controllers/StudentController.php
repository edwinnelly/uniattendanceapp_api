<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Level;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class StudentController extends Controller
{
    /**
     * Check if user is logged in and is admin
     */
    private function checkAdmin()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (auth()->user()->user_type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display a listing of students.
     */
    public function index()
    {
        $this->checkAdmin();
        
        $students = User::where('user_type', 'student')
            ->with(['program', 'level', 'department'])
            ->withCount('attendances')
            ->orderBy('name')
            ->get();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $this->checkAdmin();
        
        $programs = Program::where('is_active', true)->orderBy('name')->get();
        $levels = Level::get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $parents = User::where('user_type', 'parent')->orderBy('name')->get();

        
        return view('admin.students.create', compact('programs', 'levels', 'departments', 'parents'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'student_number' => 'required|string|max:50|unique:users,student_number',
            'program_id' => 'required|exists:programs,id',
            'level_id' => 'required|exists:levels,id',
            'enrollment_year' => 'required|integer|min:2000|max:' . date('Y'),
            'parent_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'student',
            'phone' => $request->phone,
            'student_number' => $request->student_number,
            'program_id' => $request->program_id,
            'level_id' => $request->level_id,
            'enrollment_year' => $request->enrollment_year,
            'parent_id' => $request->parent_id,
            'department_id' => Program::find($request->program_id)->department_id ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $student = User::where('user_type', 'student')
                ->with(['program', 'level', 'department', 'parent', 'attendances.timetable.course'])
                ->withCount('attendances')
                ->findOrFail($id);
            
            return view('admin.students.show', compact('student'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $student = User::where('user_type', 'student')->findOrFail($id);
            
            $programs = Program::where('is_active', true)->orderBy('name')->get();
            $levels = Level::with('program')->orderBy('level_order')->get();
            $departments = Department::where('is_active', true)->orderBy('name')->get();
            $parents = User::where('user_type', 'parent')->orderBy('name')->get();

            return view('admin.students.edit', compact('student', 'programs', 'levels', 'departments', 'parents'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, $encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $student = User::where('user_type', 'student')->findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'student_number' => 'required|string|max:50|unique:users,student_number,' . $student->id,
            'program_id' => 'required|exists:programs,id',
            'level_id' => 'required|exists:levels,id',
            'enrollment_year' => 'required|integer|min:2000|max:' . date('Y'),
            'parent_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'student_number' => $request->student_number,
            'program_id' => $request->program_id,
            'level_id' => $request->level_id,
            'enrollment_year' => $request->enrollment_year,
            'parent_id' => $request->parent_id,
            'department_id' => Program::find($request->program_id)->department_id ?? null,
            'is_active' => $request->has('is_active'),
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $student = User::where('user_type', 'student')->findOrFail($id);
            $studentName = $student->name;
            
            // Check if student has attendance records
            if ($student->attendances()->count() > 0) {
                return redirect()->route('students.index')
                    ->with('error', "Cannot delete {$studentName}. They have attendance records.");
            }
            
            $student->delete();
            
            return redirect()->route('students.index')
                ->with('success', "Student '{$studentName}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}