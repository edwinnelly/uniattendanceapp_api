<?php

namespace App\Http\Controllers;

use App\Models\Sparent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SparentController extends Controller
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

        $parents = Sparent::with(['student1', 'student2', 'student3', 'student4'])
            ->orderBy('first_name')
            ->get();

        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAdmin();

        $students = User::where('user_type', 'student')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'student_number']);

        return view('admin.parents.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'student_id1' => 'nullable|string|max:20|exists:users,student_number',
            'student_id2' => 'nullable|string|max:20|exists:users,student_number',
            'student_id3' => 'nullable|string|max:20|exists:users,student_number',
            'student_id4' => 'nullable|string|max:20|exists:users,student_number',
            'title' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => 'required|email|unique:sparents,email',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:150',
            'home_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:150',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'relationship_type' => 'nullable|string|max:50',
            'relationship_to_student' => 'nullable|string|max:50',
            'is_primary_contact' => 'boolean',
            'receives_notifications' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Resolve student IDs (if student number is entered, find the ID)
        $student1Id = $this->resolveStudentId($request->student_id1);
        $student2Id = $this->resolveStudentId($request->student_id2);
        $student3Id = $this->resolveStudentId($request->student_id3);
        $student4Id = $this->resolveStudentId($request->student_id4);

        Sparent::create([
            'student_id1' => $student1Id,
            'student_id2' => $student2Id,
            'student_id3' => $student3Id,
            'student_id4' => $student4Id,
            'title' => $request->title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'occupation' => $request->occupation,
            'home_address' => $request->home_address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'relationship_type' => $request->relationship_type,
            'relationship_to_student' => $request->relationship_to_student,
            'is_primary_contact' => $request->has('is_primary_contact'),
            'receives_notifications' => $request->has('receives_notifications'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('parents.index')
            ->with('success', 'Parent created successfully.');
    }

    /**
     * Resolve student ID from input (can be numeric ID or student number)
     */
    private function resolveStudentId($input)
    {
        if (empty($input)) {
            return null;
        }

        // If numeric, assume it's the ID
        if (is_numeric($input)) {
            $student = User::where('id', $input)->where('user_type', 'student')->first();
            return $student ? $student->id : null;
        }

        // Otherwise, search by student number
        $student = User::where('student_number', $input)->where('user_type', 'student')->first();
        return $student ? $student->id : null;
    }



    public function show($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);

            // First, get the parent without relationships to check
            $parent = Sparent::findOrFail($id);

            // Debug: Check if student exists in users table
            $studentExists = \App\Models\User::whereIn('student_number', [
                $parent->student_id1,
                $parent->student_id2,
                $parent->student_id3,
                $parent->student_id4
            ])->exists();



            // Load relationships
            $parent->load(['student1', 'student2', 'student3', 'student4']);


            // If student1 is null but student_id1 exists, check manually
            if ($parent->student_id1 && !$parent->student1) {
                $manualStudent = \App\Models\User::find($parent->student_id1);
            }
            return view('admin.parents.show', compact('parent'));
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
            $parent = Sparent::findOrFail($id);

            $students = User::where('user_type', 'student')
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'student_number']);

            return view('admin.parents.edit', compact('parent', 'students'));
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
            $parent = Sparent::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'student_id1' => 'nullable|exists:users,student_number',
            'student_id2' => 'nullable|exists:users,student_number',
            'student_id3' => 'nullable|exists:users,student_number',
            'student_id4' => 'nullable|exists:users,student_number',
            'title' => 'nullable|string|max:20',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:sparents,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:150',
            'home_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:150',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'relationship_type' => 'nullable|string|max:50',
            'relationship_to_student' => 'nullable|string|max:50',
            'is_primary_contact' => 'boolean',
            'receives_notifications' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $parent->update([
            'student_id1' => $request->student_id1,
            'student_id2' => $request->student_id2,
            'student_id3' => $request->student_id3,
            'student_id4' => $request->student_id4,
            'title' => $request->title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alternate_phone' => $request->alternate_phone,
            'occupation' => $request->occupation,
            'home_address' => $request->home_address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'relationship_type' => $request->relationship_type,
            'relationship_to_student' => $request->relationship_to_student,
            'is_primary_contact' => $request->has('is_primary_contact'),
            'receives_notifications' => $request->has('receives_notifications'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('parents.index')
            ->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $parent = Sparent::findOrFail($id);
            $parentName = $parent->full_name;

            $parent->delete();

            return redirect()->route('parents.index')
                ->with('success', "Parent '{$parentName}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
