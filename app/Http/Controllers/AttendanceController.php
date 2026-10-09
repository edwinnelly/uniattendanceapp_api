<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'timetable.course', 'timetable.location']);

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($s) use ($search) {
                    $s->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('student_number', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('timetable.course', function ($c) use ($search) {
                    $c->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('code', 'LIKE', "%{$search}%");
                });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('clock_in_time', $request->date);
        }

        $attendance = $query->orderBy('clock_in_time', 'desc')->paginate(15)->withQueryString();

        return view('admin.attendance.index', compact('attendance'));
    }

    public function create()
    {
        $students = User::where('user_type', 'student')->orderBy('name')->get();
        $timetables = Timetable::with(['course', 'location'])->orderBy('date', 'desc')->get();

        return view('admin.attendance.create', compact('students', 'timetables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'timetable_id' => 'required|exists:timetables,id',
            'clock_in_time' => 'required|date',
            'clock_out_time' => 'nullable|date|after:clock_in_time',
            'clock_in_latitude' => 'required|numeric|between:-90,90',
            'clock_in_longitude' => 'required|numeric|between:-180,180',
            'clock_in_accuracy' => 'nullable|numeric',
            'distance_meters' => 'nullable|numeric',
            'status' => 'required|in:present,late,absent,excused',
            'source' => 'required|in:mobile,web,manual,qr_code',
            'remarks' => 'nullable|string',
        ]);

        // Check for duplicate
        $exists = Attendance::where('student_id', $validated['student_id'])
            ->where('timetable_id', $validated['timetable_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Attendance already recorded for this student and timetable.');
        }

        $attendance = Attendance::create($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance recorded successfully.');
    }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $attendance = Attendance::with(['student', 'timetable.course', 'timetable.location', 'timetable.lecturer'])->findOrFail($id);

            return view('admin.attendance.show', compact('attendance'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $attendance = Attendance::findOrFail($id);

            $students = User::where('user_type', 'student')->orderBy('name')->get();
            $timetables = Timetable::with(['course', 'location'])->orderBy('date', 'desc')->get();

            return view('admin.attendance.edit', compact('attendance', 'students', 'timetables'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $attendance = Attendance::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'required|exists:users,id',
                'timetable_id' => 'required|exists:timetables,id',
                'clock_in_time' => 'required|date',
                'clock_out_time' => 'nullable|date|after:clock_in_time',
                'clock_in_latitude' => 'required|numeric|between:-90,90',
                'clock_in_longitude' => 'required|numeric|between:-180,180',
                'clock_in_accuracy' => 'nullable|numeric',
                'distance_meters' => 'nullable|numeric',
                'status' => 'required|in:present,late,absent,excused',
                'source' => 'required|in:mobile,web,manual,qr_code',
                'remarks' => 'nullable|string',
            ]);

            $attendance->update($validated);

            return redirect()->route('attendance.index')
                ->with('success', 'Attendance updated successfully.');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return redirect()->route('attendance.index')
                ->with('success', 'Attendance record deleted successfully.');
        } catch (\Exception $e) {
            abort(404);
        }
    }
}