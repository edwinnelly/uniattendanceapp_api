<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LevelController extends Controller
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

        $levels = Level::get();

        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        $this->checkAdmin();

        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:levels,name',
            'code'        => 'required|string|max:20|unique:levels,code',
            'description' => 'nullable|string',
        ]);

        $validated['code'] = strtoupper($validated['code']);

        Level::create($validated);

        return redirect()
            ->route('levels.index')
            ->with('success', 'Level created successfully.');
    }

    public function show($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $level = Level::findOrFail($id);

            return view('admin.levels.show', compact('level'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function edit($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $level = Level::findOrFail($id);

            return view('admin.levels.edit', compact('level'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

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
            'name'        => 'required|string|max:50',
            'code'        => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $name = $request->name;
        $code = strtoupper($request->code);

        // Skip the current record when checking for duplicates
        $duplicate = Level::where('id', '!=', $level->id)
            ->where(function ($q) use ($name, $code) {
                $q->where('name', $name)->orWhere('code', $code);
            })
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['name' => 'Level name or code already exists.'])
                ->withInput();
        }

        $level->update([
            'name'        => $name,
            'code'        => $code,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Level updated successfully');
    }

    public function destroy($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $level = Level::findOrFail($id);
            $name = $level->name;

            $level->delete();

            return redirect()
                ->route('levels.index')
                ->with('success', "Level '{$name}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}