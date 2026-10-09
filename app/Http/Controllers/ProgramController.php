<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProgramController extends Controller
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
        $programs = Program::with(['department', 'levels', 'students'])
            ->withCount(['students', 'levels'])
            ->orderBy('name')
            ->get();

        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $this->checkAdmin();
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.programs.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $this->checkAdmin();
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:programs',
            'duration_years' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Program::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'duration_years' => $request->duration_years,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Program created successfully');
    }

    /**
     * Display the specified resource.
     */
    // public function show($encryptedId)
    // {

    //     try {
    //         $id = Crypt::decrypt($encryptedId);
    //         $program = Program::findOrFail($id);
    //         return view('admin.programs.show', compact('program'));
    //     } catch (\Exception $e) {
    //         abort(404);
    //     }
    // }

  public function show($encryptedId)
    {
         $this->checkAdmin();
        try {
            $id = Crypt::decrypt($encryptedId);
            $program = Program::findOrFail($id);
            
            return view('admin.programs.show', compact('program'));
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
            $program = Program::findOrFail($id);
            
            $departments = Department::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'code']);

            return view('admin.programs.edit', compact('program', 'departments'));
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
            $program = Program::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:programs,code,' . $program->id,
            'duration_years' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $program->update([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'duration_years' => $request->duration_years,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
         $this->checkAdmin();
        try {
            $id = Crypt::decrypt($encryptedId);
            $program = Program::findOrFail($id);
            $programName = $program->name;
            $program->delete();
            
            return redirect()->route('programs.index')
                ->with('success', "Program '{$programName}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}