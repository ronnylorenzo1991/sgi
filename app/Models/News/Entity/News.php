<?php

namespace App\Models\News\Entity;

use App\Models\Reports\Entity\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class News extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title',
        'body',
        'url',
    ];

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}
