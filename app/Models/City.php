<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Trip;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['city'];

    public function origin()
    {
        $this->hasOne(Trip::class, 'id', 'origin');
    }
}
