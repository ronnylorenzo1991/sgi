<?php

namespace App\Models\Availability\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Availability extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'site_id',
        'description',
        'availability',
    ];
}
