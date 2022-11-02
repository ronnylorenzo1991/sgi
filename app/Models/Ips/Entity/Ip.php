<?php

namespace App\Models\Ips\Entity;

use App\Models\Countries\Entity\country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }
}
