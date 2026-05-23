<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ===== HELPERS =====
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isTeknisi(): bool
    {
        return $this->role === 'teknisi';
    }

    public function isAdminOrOperator(): bool
    {
        return in_array($this->role, ['admin', 'operator']);
    }

    // ===== RELASI =====

    // Jadwal yang dibuat oleh user ini
    public function createdSchedules()
    {
        return $this->hasMany(MaintenanceSchedule::class, 'created_by');
    }

    // Jadwal yang di-assign ke user ini
    public function assignedSchedules()
    {
        return $this->hasMany(MaintenanceSchedule::class, 'assigned_to');
    }

    // Log maintenance yang dilaporkan user ini
    public function reportedLogs()
    {
        return $this->hasMany(MaintenanceLog::class, 'reported_by');
    }

    // Log maintenance yang di-assign ke user ini
    public function assignedLogs()
    {
        return $this->hasMany(MaintenanceLog::class, 'assigned_to');
    }
}