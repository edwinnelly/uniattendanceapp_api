<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LevelController extends Controller
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
        
        $levels = Level::with(['program', 'students'])
            ->withCount('students')
            ->orderBy('program_id')
            ->orderBy('level_order')
            ->get();

        return view('admin.levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAdmin();
        
        $programs = Program::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.levels.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20',
            'level_order' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Check for duplicate name/code within the same program
        $exists = Level::where('program_id', $request->program_id)
            ->where(function($query) use ($request) {
                $query->where('name', $request->name)
                      ->orWhere('code', $request->code);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Level name or code already exists for this program.'])->withInput();
        }

        Level::create([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'level_order' => $request->level_order,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Level created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $level = Level::with(['program', 'students', 'courses'])
                ->withCount(['students', 'courses'])
                ->findOrFail($id);
            
            return view('admin.levels.show', compact('level'));
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
            $level = Level::findOrFail($id);
            
            $programs = Program::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'code']);

            return view('admin.levels.edit', compact('level', 'programs'));
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
            $level = Level::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20',
            'level_order' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Check for duplicate name/code within the same program (excluding current)
        $exists = Level::where('program_id', $request->program_id)
            ->where('id', '!=', $level->id)
            ->where(function($query) use ($request) {
                $query->where('name', $request->name)
                      ->orWhere('code', $request->code);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Level name or code already exists for this program.'])->withInput();
        }

        $level->update([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'level_order' => $request->level_order,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Level updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        $this->checkAdmin();
        
        try {
            $id = Crypt::decrypt($encryptedId);
            $level = Level::findOrFail($id);
            $levelName = $level->name;
            $level->delete();
            
            return redirect()->route('levels.index')
                ->with('success', "Level '{$levelName}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}