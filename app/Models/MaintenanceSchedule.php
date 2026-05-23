<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'scheduled_date',
        'repeat_every',
        'next_schedule',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'next_schedule'  => 'date',
        ];
    }

    // ===== HELPERS =====
    public function isUpcoming(): bool
    {
        return $this->status === 'upcoming';
    }

    public function isDone(): bool
    {
        return $this->status === 'done';
    }

    public function isRepeating(): bool
    {
        return !is_null($this->repeat_every);
    }

    // ===== RELASI =====

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Log maintenance yang terkait jadwal ini
    public function logs()
    {
        return $this->hasMany(MaintenanceLog::class, 'schedule_id');
    }
}