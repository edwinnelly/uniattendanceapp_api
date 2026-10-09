<?php

namespace App\Services;

use App\Models\LectureLocation;
use App\Models\Timetable;
use Carbon\Carbon;

class GeofenceService
{
    /**
     * Calculate distance between two coordinates using Haversine formula.
     *
     * @param float $lat1 Latitude of point 1
     * @param float $lon1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lon2 Longitude of point 2
     * @return float Distance in meters
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    /**
     * Check if user is within geofence.
     *
     * @param float $userLat User's current latitude
     * @param float $userLng User's current longitude
     * @param int $locationId Lecture location ID
     * @param float|null $accuracy GPS accuracy in meters
     * @return array
     */
    public function isWithinGeofence($userLat, $userLng, $locationId, $accuracy = null)
    {
        $location = LectureLocation::findOrFail($locationId);

        $distance = $this->calculateDistance(
            $userLat,
            $userLng,
            $location->latitude,
            $location->longitude
        );

        // Consider GPS accuracy in validation
        $effectiveRadius = $location->radius_meters;
        if ($accuracy && $accuracy > 20) {
            // Reduce effective radius for poor GPS accuracy
            $effectiveRadius = max(10, $location->radius_meters - $accuracy);
        }

        return [
            'success' => $distance <= $effectiveRadius,
            'distance' => $distance,
            'radius' => $effectiveRadius,
            'location' => $location
        ];
    }

    /**
     * Check if attendance window is valid.
     *
     * @param Timetable $timetable
     * @return array
     */
    public function isWithinAttendanceWindow(Timetable $timetable)
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($timetable->date->format('Y-m-d') . ' ' . $timetable->start_time->format('H:i:s'));

        // Allow clock-in from X minutes before to X minutes after start
        $windowStart = $startTime->copy()->subMinutes($timetable->attendance_window_minutes);
        $windowEnd = $startTime->copy()->addMinutes($timetable->attendance_window_minutes);

        return [
            'can_clock_in' => $now->between($windowStart, $windowEnd),
            'window_start' => $windowStart,
            'window_end' => $windowEnd,
            'is_late' => $now->greaterThan($startTime)
        ];
    }
}