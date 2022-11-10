<?php

namespace App\Models\Nodes\Entity;

use App\Models\Countries\Entity\country;
use App\Models\Entities\Entity\Entity;
use App\Models\Events\Entity\Event;
use App\Models\InternetLinks\Entity\InternetLink;
use App\Models\Ips\Entity\Ip;
use App\Models\Ministries\Entity\Ministry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Node extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'ip_id',
        'entity_id',
        'ministry_id',
        'internet_link_id',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function internetLink()
    {
        return $this->belongsTo(InternetLink::class);
    }

    public function ip()
    {
        return $this->belongsTo(Ip::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
