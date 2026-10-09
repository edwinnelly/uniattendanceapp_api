<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CourseController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAdmin();
        
        $courses = Course::with(['department', 'level'])
            ->orderBy('code')
            ->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAdmin();
        
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $levels = Level::with('program')->orderBy('name')->get();

        return view('admin.courses.create', compact('departments', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'nullable|exists:levels,id',
            'code' => 'required|string|max:20|unique:courses',
            'title' => 'required|string|max:60',
            'credit_hours' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Course::create([
            'department_id' => $request->department_id,
            'level_id' => $request->level_id,
            'code' => strtoupper($request->code),
            'title' => $request->title,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $course = Course::with(['department', 'level', 'timetables'])
                ->findOrFail($id);
            
            return view('admin.courses.show', compact('course'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $course = Course::findOrFail($id);
            
            $departments = Department::where('is_active', true)->orderBy('name')->get();
            $levels = Level::with('program')->orderBy('name')->get();

            return view('admin.courses.edit', compact('course', 'departments', 'levels'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $course = Course::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'nullable|exists:levels,id',
            'code' => 'required|string|max:20|unique:courses,code,' . $course->id,
            'title' => 'required|string|max:60',
            'credit_hours' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $course->update([
            'department_id' => $request->department_id,
            'level_id' => $request->level_id,
            'code' => strtoupper($request->code),
            'title' => $request->title,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $course = Course::findOrFail($id);
            $courseTitle = $course->title;
            $course->delete();
            
            return redirect()->route('courses.index')
                ->with('success', "Course '{$courseTitle}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}