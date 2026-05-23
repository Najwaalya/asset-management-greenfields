<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MaintenanceLog;
use App\Models\AssetCategory;

class Asset extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'location',
        'status',
        'description',
        'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
