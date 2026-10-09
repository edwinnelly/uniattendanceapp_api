<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Course;
use App\Models\User;
use App\Models\LectureLocation;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Program;

class TimetableController extends Controller
{
    // public function index()
    // {
    //     $timetables = Timetable::with(['course', 'lecturer', 'location', 'level'])
    //         ->orderBy('date', 'desc')
    //         ->orderBy('start_time', 'desc')
    //         ->paginate(15);

    //          //dd($timetables);

    //     return view('admin.timetables.index', compact('timetables'));
    // }

    public function index(Request $request)
    {
        $query = Timetable::with(['course', 'lecturer', 'location', 'level']);

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('course', function ($c) use ($search) {
                    $c->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('code', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('lecturer', function ($l) use ($search) {
                        $l->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('location', function ($loc) use ($search) {
                        $loc->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date', $request->date);
        }

        $timetables = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.timetables.index', compact('timetables'));
    }

    public function create()
    {
        $programs = Program::orderBy('name')->get();
        $courses = Course::orderBy('title')->get();
        $lecturers = User::where('user_type', 'lecturer')->orderBy('name')->get();
        $locations = LectureLocation::active()->orderBy('name')->get();
        $levels = Level::orderBy('name')->get();

        //dd($levels);

        return view('admin.timetables.create', compact('programs', 'courses', 'lecturers', 'locations', 'levels'));
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'program_id' => 'required|exists:programs,id',
        'course_id' => 'required|exists:courses,id',
        'lecturer_id' => 'required|exists:users,id',
        'location_id' => 'required|exists:lecture_locations,id',
        'level_id' => 'nullable|exists:levels,id',
        'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'attendance_window_minutes' => 'nullable|integer|min:1|max:120',
        'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        'cancel_reason' => 'nullable|string',
    ]);

    $validated['attendance_window_minutes'] = $validated['attendance_window_minutes'] ?? 15;

    $timetable = Timetable::create($validated);

    return redirect()
        ->route('timetables.index')
        ->with('success', 'Timetable created successfully.');
}

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $timetable = Timetable::with(['course', 'lecturer', 'location', 'level'])->findOrFail($id);

            return view('admin.timetables.show', compact('timetable'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $timetable = Timetable::findOrFail($id);


            $courses = Course::orderBy('title')->get();
            $lecturers = User::where('user_type', 'lecturer')->orderBy('name')->get();
            $locations = LectureLocation::active()->orderBy('name')->get();
            $levels = Level::orderBy('name')->get();

            // dd($locations);

            return view('admin.timetables.edit', compact('timetable', 'courses', 'lecturers', 'locations', 'levels'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $timetable = Timetable::findOrFail($id);

            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'lecturer_id' => 'required|exists:users,id',
                'location_id' => 'required|exists:lecture_locations,id',
                'level_id' => 'nullable|exists:levels,id',
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'attendance_window_minutes' => 'nullable|integer|min:1|max:120',
                'status' => 'required|in:scheduled,ongoing,completed,cancelled',
                'cancel_reason' => 'nullable|string',
            ]);

            $validated['attendance_window_minutes'] = $validated['attendance_window_minutes'] ?? 15;

            // Check for scheduling conflict (excluding current timetable)
            $conflict = Timetable::where('location_id', $validated['location_id'])
                ->where('date', $validated['date'])
                ->where('id', '!=', $timetable->id)
                ->where(function ($q) use ($validated) {
                    $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhere(function ($q2) use ($validated) {
                            $q2->where('start_time', '<=', $validated['start_time'])
                                ->where('end_time', '>=', $validated['end_time']);
                        });
                })
                ->where('status', '!=', 'cancelled')
                ->exists();

            if ($conflict) {
                return back()
                    ->withInput()
                    ->with('error', 'There is a scheduling conflict at this location and time.');
            }

            $timetable->update($validated);

            return redirect()
                ->route('timetables.index')
                ->with('success', 'Timetable updated successfully.');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $timetable = Timetable::findOrFail($id);
            $timetable->delete();

            return redirect()
                ->route('timetables.index')
                ->with('success', 'Timetable deleted successfully.');
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
