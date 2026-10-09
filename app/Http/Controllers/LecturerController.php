<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LecturerController extends Controller
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

        $lecturers = User::where('user_type', 'lecturer')
            ->with('department')
            ->withCount('timetablesAsLecturer')
            ->orderBy('name')
            ->get();

        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $this->checkAdmin();

        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.lecturers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'employee_number' => 'required|string|max:50|unique:users,employee_number',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'lecturer',
            'phone' => $request->phone,
            'employee_number' => $request->employee_number,
            'department_id' => $request->department_id,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Lecturer created successfully.');
    }

    public function show($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $lecturer = User::where('user_type', 'lecturer')
                ->with(['department', 'timetablesAsLecturer.course', 'timetablesAsLecturer.location'])
                ->withCount('timetablesAsLecturer')
                ->findOrFail($id);

            return view('admin.lecturers.show', compact('lecturer'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function edit($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $lecturer = User::where('user_type', 'lecturer')->findOrFail($id);

            $departments = Department::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'code']);

            return view('admin.lecturers.edit', compact('lecturer', 'departments'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, $encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $lecturer = User::where('user_type', 'lecturer')->findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lecturer->id,
            'phone' => 'nullable|string|max:20',
            'employee_number' => 'required|string|max:50|unique:users,employee_number,' . $lecturer->id,
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'employee_number' => $request->employee_number,
            'department_id' => $request->department_id,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $lecturer->update($data);

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer updated successfully.');
    }

    public function destroy($encryptedId)
    {
        $this->checkAdmin();

        try {
            $id = Crypt::decrypt($encryptedId);
            $lecturer = User::where('user_type', 'lecturer')->findOrFail($id);
            $lecturerName = $lecturer->name;

            if ($lecturer->timetablesAsLecturer()->count() > 0) {
                return redirect()->route('lecturers.index')
                    ->with('error', "Cannot delete {$lecturerName}. They have assigned timetables.");
            }

            if ($lecturer->headedDepartment()->count() > 0) {
                return redirect()->route('lecturers.index')
                    ->with('error', "Cannot delete {$lecturerName}. They are a department head.");
            }

            $lecturer->delete();

            return redirect()->route('lecturers.index')
                ->with('success', "Lecturer '{$lecturerName}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
