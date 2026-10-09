<?php

namespace App\Http\Controllers;

use App\Models\LectureLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class LectureLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LectureLocation::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by active status
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        // Filter by capacity
        if ($request->has('min_capacity') && !empty($request->min_capacity)) {
            $query->where('capacity', '>=', $request->min_capacity);
        }

        // Filter by building
        if ($request->has('building') && !empty($request->building)) {
            $query->where('building', $request->building);
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Get distinct buildings for filter dropdown
        $buildings = LectureLocation::distinct()->pluck('building')->filter()->values();

        $locations = $query->paginate(15)->withQueryString();


        return view('admin.locations.index', compact('locations', 'buildings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:lecture_locations,code',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'nullable|integer|min:1|max:10000',
            'building' => 'nullable|string|max:100',
            'floor' => 'nullable|string|max:20',
            'room_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1|max:10000',
            'is_active' => 'boolean',
        ]);

        // Set default radius if not provided
        $validated['radius_meters'] = $validated['radius_meters'] ?? 50;
        $validated['is_active'] = $request->has('is_active');

        $location = LectureLocation::create($validated);

        return redirect()
            ->route('lecture-locations.index')
            ->with('success', "Lecture location '{$location->name}' created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);

            $lectureLocation = LectureLocation::findOrFail($id);

            return view('admin.locations.show', compact('lectureLocation'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $lectureLocation = LectureLocation::findOrFail($id);

            return view('admin.locations.edit', compact('lectureLocation'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $lectureLocation = LectureLocation::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:150',
                'code' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('lecture_locations', 'code')->ignore($lectureLocation->id),
                ],
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'radius_meters' => 'nullable|integer|min:1|max:10000',
                'building' => 'nullable|string|max:100',
                'floor' => 'nullable|string|max:20',
                'room_number' => 'nullable|string|max:50',
                'capacity' => 'nullable|integer|min:1|max:10000',
                'is_active' => 'boolean',
            ]);

            // Set default radius if not provided
            $validated['radius_meters'] = $validated['radius_meters'] ?? 50;
            $validated['is_active'] = $request->has('is_active');

            $lectureLocation->update($validated);

            return redirect()
                ->route('lecture-locations.index')
                ->with('success', "Lecture location '{$lectureLocation->name}' updated successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($encryptedId)
    // {


    //     try {
    //         $id = Crypt::decrypt($encryptedId);
    //         $lectureLocation = LectureLocation::findOrFail($id);

    //         $name = $lectureLocation->name;
    //         $lectureLocation->delete();

    //         return redirect()
    //             ->route('lecture-locations')
    //             ->with('success', "Lecture location '{$name}' deleted successfully.");
    //     } catch (\Exception $e) {
    //         abort(404);
    //     }
    // }


    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $lectureLocation = LectureLocation::findOrFail($id);

            // Check if location has active timetables (optional but recommended)
           
            $name = $lectureLocation->name;
            $lectureLocation->delete();

            return redirect()
                ->route('lecture-locations.index')
                ->with('success', "Lecture location '{$name}' deleted successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }


    /**
     * Toggle the active status of the location.
     */
    public function toggleActive($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $lectureLocation = LectureLocation::findOrFail($id);

            $lectureLocation->update([
                'is_active' => !$lectureLocation->is_active
            ]);

            $status = $lectureLocation->is_active ? 'activated' : 'deactivated';

            return redirect()
                ->route('locations.index')
                ->with('success', "Location '{$lectureLocation->name}' {$status} successfully.");
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Bulk delete multiple locations.
     */

    /**
     * Export locations as CSV.
     */
    public function export()
    {
        $locations = LectureLocation::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="lecture-locations.csv"',
        ];

        $callback = function () use ($locations) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'Name',
                'Code',
                'Latitude',
                'Longitude',
                'Radius (m)',
                'Building',
                'Floor',
                'Room Number',
                'Capacity',
                'Active',
                'Created At',
            ]);

            // Add data
            foreach ($locations as $location) {
                fputcsv($file, [
                    $location->id,
                    $location->name,
                    $location->code,
                    $location->latitude,
                    $location->longitude,
                    $location->radius_meters,
                    $location->building,
                    $location->floor,
                    $location->room_number,
                    $location->capacity ?? 'N/A',
                    $location->is_active ? 'Yes' : 'No',
                    $location->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get locations for API/JSON response.
     */
    public function getLocations(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius' => 'nullable|integer|min:1|max:10000',
            'active_only' => 'boolean',
        ]);

        $query = LectureLocation::query();

        if ($request->has('active_only') && $request->active_only) {
            $query->active();
        }

        // Find nearby locations if coordinates provided
        if ($request->has('latitude') && $request->has('longitude')) {
            $radius = $request->get('radius', 1000);
            $query->nearCoordinates($request->latitude, $request->longitude, $radius);
        }

        // Search by name or code
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        $locations = $query->get();

        return response()->json([
            'success' => true,
            'count' => $locations->count(),
            'data' => $locations,
        ]);
    }

    /**
     * Get location options for dropdowns.
     */
    public function getOptions(Request $request)
    {
        $query = LectureLocation::active();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('min_capacity')) {
            $query->hasAvailableCapacity($request->min_capacity);
        }

        $locations = $query->orderBy('name')->get(['id', 'name', 'code']);

        return response()->json($locations);
    }
}
