<?php

namespace App\Models\Ips\Entity;

use App\Models\Countries\Entity\country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Ip extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'address',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }
}
