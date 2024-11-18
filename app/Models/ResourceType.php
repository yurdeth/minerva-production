<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    use HasFactory;

    protected $table = 'resource_types';

    protected $fillable = [
        'id',
        'resource_name'
    ];
}
