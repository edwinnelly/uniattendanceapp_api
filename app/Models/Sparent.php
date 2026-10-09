<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class Sparent extends Model
{
    protected $table = 'sparents';

    protected $fillable = [
        'student_id1',
        'student_id2',
        'student_id3',
        'student_id4',
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
        'alternate_phone',
        'occupation',
        'home_address',
        'city',
        'state',
        'country',
        'postal_code',
        'emergency_contact_name',
        'emergency_contact_phone',
        'relationship_type',
        'relationship_to_student',
        'is_primary_contact',
        'receives_notifications',
        'is_active',
    ];

    protected $casts = [
        'is_primary_contact' => 'boolean',
        'receives_notifications' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_name',
        'children_count',
        'encrypted_id',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the first student associated with this parent.
     */
    public function student1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id1', 'student_number')
            ->withDefault(); // This prevents null by returning a default model
    }

    /**
     * Get the second student associated with this parent.
     */
    public function student2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id2', 'student_number')
            ->withDefault();
    }

    /**
     * Get the third student associated with this parent.
     */
    public function student3(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id3', 'student_number')
            ->withDefault();
    }

    /**
     * Get the fourth student associated with this parent.
     */
    public function student4(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id4', 'student_number')
            ->withDefault();
    }

    /**
     * Get all students associated with this parent.
     * Better implementation that handles missing students gracefully.
     */
    public function getStudentsListAttribute()
    {
        $studentIds = array_filter([
            $this->student_id1,
            $this->student_id2,
            $this->student_id3,
            $this->student_id4,
        ]);

        if (empty($studentIds)) {
            return collect();
        }

        return User::whereIn('student_number', $studentIds)->get();
    }

    /**
     * Check if a student ID exists in the users table.
     */
    public function studentExists(int $studentId): bool
    {
        return User::where('student_number', $studentId)->exists();
    }

    /**
     * Get valid students (only those that actually exist in users table).
     */
    public function getValidStudentIdsAttribute(): array
    {
        $studentIds = array_filter([
            $this->student_id1,
            $this->student_id2,
            $this->student_id3,
            $this->student_id4,
        ]);

        return User::whereIn('student_number', $studentIds)->pluck('student_number')->toArray();
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active parents.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include primary contacts.
     */
    public function scopePrimaryContact(Builder $query): Builder
    {
        return $query->where('is_primary_contact', true);
    }

    /**
     * Scope a query to only include parents who receive notifications.
     */
    public function scopeReceivesNotifications(Builder $query): Builder
    {
        return $query->where('receives_notifications', true);
    }

    /**
     * Scope a query to search by full name.
     */
    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%{$search}%")
              ->orWhere('last_name', 'LIKE', "%{$search}%")
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
        });
    }

    /**
     * Scope to find by encrypted ID.
     */
    public function scopeFindByEncryptedId(Builder $query, string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            return $query->findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    // ==================== ACCESSORS ====================

    /**
     * Get the parent's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->title ? $this->title . ' ' : '') . $this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the count of children/students associated with this parent.
     */
    public function getChildrenCountAttribute(): int
    {
        return collect([$this->student_id1, $this->student_id2, $this->student_id3, $this->student_id4])
            ->filter()
            ->count();
    }

    /**
     * Get all children/students as a collection.
     */
    public function getChildrenAttribute(): \Illuminate\Support\Collection
    {
        return collect([
            $this->student1,
            $this->student2,
            $this->student3,
            $this->student4,
        ])->filter();
    }

    /**
     * Get the encrypted ID for URL-safe routing.
     */
    public function getEncryptedIdAttribute(): string
    {
        return Crypt::encrypt($this->id);
    }

    /**
     * Get the formatted phone number.
     */
    public function getFormattedPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
        }
        return $this->phone;
    }

    /**
     * Get the parent's full address as a string.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->home_address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get all student IDs associated with this parent.
     */
    public function getStudentIdsAttribute(): array
    {
        return array_filter([
            $this->student_id1,
            $this->student_id2,
            $this->student_id3,
            $this->student_id4,
        ]);
    }

    // ==================== MUTATORS ====================

    /**
     * Set the first name attribute (capitalize).
     */
    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    /**
     * Set the last name attribute (capitalize).
     */
    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    /**
     * Set the email attribute (lowercase).
     */
    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if the parent has a specific student.
     */
    public function hasStudent(int $studentId): bool
    {
        return in_array($studentId, [
            $this->student_id1,
            $this->student_id2,
            $this->student_id3,
            $this->student_id4,
        ], true) && $this->studentExists($studentId);
    }

    /**
     * Check if the parent has any children.
     */
    public function hasChildren(): bool
    {
        return $this->children_count > 0;
    }

    /**
     * Get the route key for the model (uses encrypted ID).
     */
    public function getRouteKey()
    {
        return $this->encrypted_id;
    }

    /**
     * Resolve the model using the encrypted route key.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = Crypt::decrypt($value);
            return $this->findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Static helper to find by encrypted ID.
     */
    public static function findByEncryptedId(string $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            return static::findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}