<?php

namespace App\Models\Reports\Entity;

use App\Models\Availability\Entity\Availability;
use App\Models\Events\Entity\Event;
use App\Models\News\Entity\News;
use App\Models\ReportTypes\Entity\ReportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Report extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'start_date',
        'end_date',
        'number',
        'report_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(ReportType::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->with(['nodes', 'category', 'subcategory']);
    }

    public function availabilities()
    {
        return $this->belongsToMany(Availability::class)->with('site');
    }

    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
