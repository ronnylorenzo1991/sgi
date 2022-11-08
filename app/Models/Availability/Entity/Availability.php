<?php

namespace App\Models\Availability\Entity;

use App\Models\Reports\Entity\Report;
use App\Models\Sites\Entity\Site;
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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}
