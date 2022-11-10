<?php

namespace App\Models\Countries\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class country extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
}
