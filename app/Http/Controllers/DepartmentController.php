<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DepartmentController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (auth()->user()->user_type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $this->checkAdmin();

        $departments = Department::with(['head', 'students', 'lecturers', 'courses'])->get();

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $this->checkAdmin();

        $lecturers = User::where('user_type', 'lecturer')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $faculties = Program::orderBy('name')->get();

        return view('admin.departments.create', compact('lecturers', 'faculties'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'code'           => 'required|string|max:20|unique:departments,code',
            'faculty_id'     => 'required|exists:programs,id',
            'head_id'        => 'nullable|exists:users,id',
            'duration_years' => 'required|integer|min:1|max:10',
            'description'    => 'nullable|string',
            'is_active'      => 'boolean',
        ]);

        $validated['code']      = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $department = Department::findOrFail($id);

            return view('admin.departments.show', compact('department'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function edit($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $department = Department::findOrFail($id);

            $lecturers = User::where('user_type', 'lecturer')->get();
            $faculties = Program::orderBy('name')->get();

            return view('admin.departments.edit', compact('department', 'lecturers', 'faculties'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, Department $department)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'code'           => 'required|string|max:20|unique:departments,code,' . $department->id,
            'faculty_id'     => 'nullable|exists:programs,id',
            'head_id'        => 'nullable|exists:users,id',
            'duration_years' => 'required|integer|min:1|max:10',
            'description'    => 'nullable|string|max:1000',
            'is_active'      => 'boolean',
        ]);

        $department->update([
            'name'           => $validated['name'],
            'code'           => strtoupper($validated['code']),
            'faculty_id'     => $validated['faculty_id'] ?? null,
            'head_id'        => $validated['head_id'] ?? null,
            'duration_years' => $validated['duration_years'],
            'description'    => $validated['description'] ?? null,
            'is_active'      => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Department updated successfully');
    }

    public function destroy(Department $department)
    {
        $this->checkAdmin();

        if ($department->students()->count() > 0 || $department->lecturers()->count() > 0) {
            return back()->with('error', 'Cannot delete department with associated students or lecturers.');
        }

        $name = $department->name;
        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', "Department '{$name}' deleted successfully.");
    }
}