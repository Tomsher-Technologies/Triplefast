<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
    use HasFactory;

    protected $fillable = [
        'operation_id', 'description', 'is_active', 'is_deleted'
    ];
}
