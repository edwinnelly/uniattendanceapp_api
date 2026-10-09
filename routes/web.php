<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SparentController;
use App\Http\Controllers\LectureLocationController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AttendanceController;


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Auth Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard_pro', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('departments', DepartmentController::class);
});



Route::middleware('auth')->group(function () {

    //group routes for departments
    // Route::get('/dpt/view', function () {
    //     return view('admin.departments.index');
    // });

    Route::get('/dpt/view', [DepartmentController::class, 'index'])->name('departments.index');

    Route::get('/dpt/create', [DepartmentController::class, 'create'])->name('departments.create');


    Route::post('/dpt', [DepartmentController::class, 'store'])->name('departments.store');

    Route::get('/dpt/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');

    Route::put('/dpt/{id}', [DepartmentController::class, 'update'])->name('departments.update');

    Route::delete('/dpt/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    Route::get('/views/{id}', [DepartmentController::class, 'show'])->name('departments.show');


    // Programs Resource Routes
    Route::resource('programs', ProgramController::class);

    // this is the route for the programs
    Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [ProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
    Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');


    // this is the route for the levels
    Route::get('/levels', [LevelController::class, 'index'])->name('levels.index');
    Route::get('/levels/create', [LevelController::class, 'create'])->name('levels.create');
    Route::post('/levels', [LevelController::class, 'store'])->name('levels.store');
    Route::get('/levels/{level}', [LevelController::class, 'show'])->name('levels.show');
    Route::get('/levels/{level}/edit', [LevelController::class, 'edit'])->name('levels.edit');
    Route::put('/levels/{level}', [LevelController::class, 'update'])->name('levels.update');
    Route::delete('/levels/{level}', [LevelController::class, 'destroy'])->name('levels.destroy');


    // this is the route for the courses
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');


    //this is the route for the lecturers
    Route::get('/lecturers', [LecturerController::class, 'index'])->name('lecturers.index');
    Route::get('/lecturers/create', [LecturerController::class, 'create'])->name('lecturers.create');
    Route::post('/lecturers', [LecturerController::class, 'store'])->name('lecturers.store');
    Route::get('/lecturers/{encryptedId}', [LecturerController::class, 'show'])->name('lecturers.show');
    Route::get('/lecturers/{encryptedId}/edit', [LecturerController::class, 'edit'])->name('lecturers.edit');
    Route::put('/lecturers/{encryptedId}', [LecturerController::class, 'update'])->name('lecturers.update');
    Route::delete('/lecturers/{encryptedId}', [LecturerController::class, 'destroy'])->name('lecturers.destroy');


    // this is the route for the student parents
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{encryptedId}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{encryptedId}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{encryptedId}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{encryptedId}', [StudentController::class, 'destroy'])->name('students.destroy');


    Route::get('/parents', [SparentController::class, 'index'])->name('parents.index');
    Route::get('/parents/create', [SparentController::class, 'create'])->name('parents.create');
    Route::post('/parents', [SparentController::class, 'store'])->name('parents.store');
    Route::get('/parents/{encryptedId}', [SparentController::class, 'show'])->name('parents.show');
    Route::get('/parents/{encryptedId}/edit', [SparentController::class, 'edit'])->name('parents.edit');
    Route::put('/parents/{encryptedId}', [SparentController::class, 'update'])->name('parents.update');
    Route::delete('/parents/{encryptedId}', [SparentController::class, 'destroy'])->name('parents.destroy');


    // Lecture Locations Routes
    Route::get('/lecture-locations', [LectureLocationController::class, 'index'])->name('lecture-locations.index');
    Route::get('/lecture-locations/create', [LectureLocationController::class, 'create'])->name('lecture-locations.create');
    Route::post('/lecture-locations', [LectureLocationController::class, 'store'])->name('lecture-locations.store');

    Route::get('/lecture-locations/{encryptedId}', [LectureLocationController::class, 'show'])->name('lecture-locations.show');
    Route::get('/lecture-locations/{encryptedId}/edit', [LectureLocationController::class, 'edit'])->name('lecture-locations.edit');
    Route::put('/lecture-locations/{encryptedId}', [LectureLocationController::class, 'update'])->name('lecture-locations.update');
    Route::delete('/lecture-locations/{encryptedId}', [LectureLocationController::class, 'destroy'])->name('lecture-locations.destroy');


    // Timetable Routes
    Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');
    Route::get('/timetables/create', [TimetableController::class, 'create'])->name('timetables.create');
    Route::post('/timetables', [TimetableController::class, 'store'])->name('timetables.store');
    Route::get('/timetables/{encryptedId}', [TimetableController::class, 'show'])->name('timetables.show');
    Route::get('/timetables/{encryptedId}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
    Route::put('/timetables/{encryptedId}', [TimetableController::class, 'update'])->name('timetables.update');
    Route::delete('/timetables/{encryptedId}', [TimetableController::class, 'destroy'])->name('timetables.destroy');


    // Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{encryptedId}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{encryptedId}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{encryptedId}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{encryptedId}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
