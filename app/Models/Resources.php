<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model {
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'id',
        'fixed_asset_code', // Número de activo fijo
        'resource_type_id',
        'status_id',
        'room_id',
    ];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function resourceType() {
        return $this->belongsTo(ResourceType::class);
    }
}
