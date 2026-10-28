<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Timetable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ═══ Stat cards ═══
        $students = User::where('user_type', 'student')->count();
        $lecturers = User::where('user_type', 'lecturer')->count();
        $courses   = Course::count();
        $departments = Department::count();

        $newStudents7d = User::where('user_type', 'student')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $newLecturers7d = User::where('user_type', 'lecturer')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // ═══ Today's attendance ═══
        $todayQuery = Attendance::whereDate('session_date', $today);
        $todayTotal   = (clone $todayQuery)->count();
        $todayPresent = (clone $todayQuery)->whereIn('status', ['present', 'late'])->count();
        $todayRate    = $todayTotal > 0 ? round(($todayPresent / $todayTotal) * 100) : 0;

        // ═══ Weekly chart data ═══
        $weekly = Attendance::select(
                DB::raw('DATE(session_date) as day'),
                DB::raw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present"),
                DB::raw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late"),
                DB::raw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent")
            )
            ->whereBetween('session_date', [now()->subDays(6), now()])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Fill missing days with zeros so the chart doesn't skip dates
        $labels = [];
        $presentData = [];
        $lateData = [];
        $absentData = [];
        $lookup = $weekly->keyBy('day');

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[]      = now()->subDays($i)->format('D');
            $presentData[] = $lookup[$date]->present ?? 0;
            $lateData[]    = $lookup[$date]->late ?? 0;
            $absentData[]  = $lookup[$date]->absent ?? 0;
        }

        $chart = [
            'labels'  => $labels,
            'present' => $presentData,
            'late'    => $lateData,
            'absent'  => $absentData,
        ];

        // ═══ Students by department chart ═══
        $deptRows = User::select('department_id', DB::raw('COUNT(*) as total'))
            ->where('user_type', 'student')
            ->whereNotNull('department_id')
            ->groupBy('department_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $deptNames = Department::whereIn('id', $deptRows->pluck('department_id'))
            ->pluck('name', 'id');

        $deptChart = [
            'labels' => $deptRows->map(fn($r) => $deptNames[$r->department_id] ?? 'Unknown')->toArray(),
            'data'   => $deptRows->pluck('total')->toArray(),
        ];

        // If departments are empty, show a placeholder
        if (empty($deptChart['data'])) {
            $deptChart = ['labels' => ['No data'], 'data' => [1]];
        }

        // ═══ Recent attendance ═══
        $recent = Attendance::with(['student', 'timetable.course'])
            ->latest('clock_in_time')
            ->take(5)
            ->get();

        // ═══ Upcoming classes (today, from now) ═══
        $now = now();
        $todayName = strtolower($now->englishDayOfWeek);

        $upcoming = Timetable::with(['course', 'location', 'lecturer'])
            ->where('day_of_week', $todayName)
            ->where('start_time', '>=', $now->format('H:i:s'))
            ->whereIn('status', ['scheduled', 'ongoing'])
            ->orderBy('start_time')
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'students', 'lecturers', 'courses', 'departments',
            'newStudents7d', 'newLecturers7d',
            'todayRate', 'todayPresent', 'todayTotal',
            'chart', 'deptChart',
            'recent', 'upcoming'
        ));
    }
}