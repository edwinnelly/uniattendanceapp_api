<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LectureLocation extends Model
{
    use HasFactory;

    protected $table = 'lecture_locations';

    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'radius_meters',
        'building',
        'floor',
        'room_number',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'radius_meters' => 'integer',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_address',
        'coordinates',
        'formatted_capacity',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the timetables for this lecture location.
     */
    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class, 'location_id', 'id');
    }

    /**
     * Get the lecture sessions for this location.
     */
    public function lectureSessions(): HasMany
    {
        return $this->hasMany(LectureSession::class, 'location_id', 'id');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active locations.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search by name or code.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('code', 'LIKE', "%{$search}%")
              ->orWhere('building', 'LIKE', "%{$search}%")
              ->orWhere('room_number', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to find locations within a certain radius of coordinates.
     */
    public function scopeNearCoordinates(Builder $query, float $latitude, float $longitude, int $radiusInMeters = 100): Builder
    {
        // Haversine formula for distance calculation
        return $query->whereRaw(
            "(6371000 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) < ?",
            [$latitude, $longitude, $latitude, $radiusInMeters]
        );
    }

    /**
     * Scope to get locations with available capacity (for scheduling).
     */
    public function scopeHasAvailableCapacity(Builder $query, int $minCapacity = 1): Builder
    {
        return $query->where(function ($q) use ($minCapacity) {
            $q->whereNull('capacity')
              ->orWhere('capacity', '>=', $minCapacity);
        });
    }

    // ==================== ACCESSORS & MUTATORS ====================

    /**
     * Get the full address/description of the location.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->building,
            $this->floor ? "Floor {$this->floor}" : null,
            $this->room_number ? "Room {$this->room_number}" : null,
        ]);

        return $this->name . ($parts ? ' - ' . implode(', ', $parts) : '');
    }

    /**
     * Get the coordinates as an array.
     */
    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /**
     * Get formatted capacity.
     */
    public function getFormattedCapacityAttribute(): string
    {
        if ($this->capacity === null) {
            return 'Unlimited';
        }
        return "{$this->capacity} seats";
    }

    /**
     * Get the Google Maps URL for this location.
     */
    public function getGoogleMapsUrlAttribute(): string
    {
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }

    /**
     * Get the OpenStreetMap URL for this location.
     */
    public function getOpenStreetMapUrlAttribute(): string
    {
        return "https://www.openstreetmap.org/?mlat={$this->latitude}&mlon={$this->longitude}";
    }

    /**
     * Set the code attribute (uppercase).
     */
    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    /**
     * Set the name attribute (proper case).
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucwords(trim($value));
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if this location is within a radius of given coordinates.
     */
    public function isWithinRadius(float $latitude, float $longitude, ?int $customRadius = null): bool
    {
        $radius = $customRadius ?? $this->radius_meters;
        $distance = $this->calculateDistance($latitude, $longitude);
        return $distance <= $radius;
    }

    /**
     * Calculate distance from this location to given coordinates (in meters).
     */
    public function calculateDistance(float $latitude, float $longitude): float
    {
        $earthRadius = 6371000; // in meters
        
        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);
        
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    /**
     * Check if the location has capacity for a given number of students.
     */
    public function hasCapacity(int $studentsCount): bool
    {
        if ($this->capacity === null) {
            return true;
        }
        return $this->capacity >= $studentsCount;
    }

    /**
     * Get the number of active timetables for this location.
     */
    public function getActiveTimetablesCount(): int
    {
        return $this->timetables()->where('is_active', true)->count();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    // ==================== STATIC METHODS ====================

    /**
     * Find a location by its code.
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', strtoupper($code))->first();
    }

    /**
     * Get all active locations as an associative array (id => name).
     */
    public static function getActiveOptions(): array
    {
        return static::active()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get all active locations with their codes.
     */
    public static function getActiveWithCodes(): array
    {
        return static::active()
            ->orderBy('name')
            ->get(['id', 'name', 'code'])
            ->toArray();
    }
}