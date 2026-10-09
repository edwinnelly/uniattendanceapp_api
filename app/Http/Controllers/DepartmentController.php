<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DepartmentController extends Controller
{

    private function checkAdmin()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Check if user is admin
        if (auth()->user()->user_type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAdmin();
        $departments = Department::with(['head', 'students', 'lecturers', 'courses'])->get();

        return view('admin.departments.index', compact('departments'));
    }


    public function create()
    {
        $this->checkAdmin();
        // Fetch lecturers from users table
        $lecturers = User::where('user_type', 'lecturer')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.departments.create', compact('lecturers'));
    }


    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:departments',
            'head_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department = Department::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'head_id' => $request->head_id,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);
        // Or just return back with success message
        return back()->with('success', 'Department created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->checkAdmin();
        $id = Crypt::decrypt($id);
        $department = Department::findOrFail($id);
        // dd($department);÷

        return view('admin.departments.show', compact('department'));
    }

    public function edit($encryptedId)
    {
        $this->checkAdmin();
        try {
            $id = Crypt::decrypt($encryptedId);
            $department = Department::findOrFail($id);
            $lecturers = User::where('user_type', 'lecturer')->get();
            return view('admin.departments.edit', compact('department', 'lecturers'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, Department $department)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'head_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'head_id' => $request->head_id,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->checkAdmin();
        // Check if department has associated records
        if ($department->students()->count() > 0 || $department->lecturers()->count() > 0) {
            return back()->with('error', 'Cannot delete department with associated students or lecturers.');
        }

        // Delete the department
        $department->delete();

        // Redirect to index with success message
        return redirect()->route('admin.departments.index')
            ->with('success', "Department '{$department->name}' deleted successfully.");
    }
}
