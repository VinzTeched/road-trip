<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude', 'order', 'journey_id'];

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}
