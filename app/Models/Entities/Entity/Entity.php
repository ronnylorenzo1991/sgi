<?php

namespace App\Models\Entities\Entity;

use App\Models\Countries\Entity\country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }
}
