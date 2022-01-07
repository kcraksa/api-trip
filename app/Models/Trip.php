<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\City;
use App\Models\TripType;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'origin_id', 'destination_id', 'start_date', 'end_date', 'trip_types_id', 'description'];

    public function origin()
    {
        return $this->belongsTo(City::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(City::class, 'destination_id');
    }

    public function trip_type()
    {
        return $this->belongsTo(TripType::class, 'trip_types_id');
    }
}
