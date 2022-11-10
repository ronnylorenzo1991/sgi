<?php

namespace App\Models\Events\Entity;

use App\Models\Categories\Entity\Category;
use App\Models\Contributes\Entity\Contribute;
use App\Models\Nodes\Entity\Node;
use App\Models\Reports\Entity\Report;
use App\Models\Sources\Entity\Source;
use App\Models\Subcategories\Entity\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'number',
        'observations',
        'national_as_source',
        'subcategory_id',
        'category_id',
        'detected_by_id',
        'contribute_id',
        'date',
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function detectedBy()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contribute()
    {
        return $this->belongsTo(Contribute::class);
    }

    public function nodes()
    {
        return $this->belongsToMany(Node::class)->with('ip');
    }

    public function sourceNodes()
    {
        return $this->nodes()->where('is_source', true);
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }

    public function destinationNodes()
    {
        return $this->nodes()->where('is_source', false);
    }

    public function hasPermissionGroup($permission = "")
    {
        $permissions = auth()->user()->getAllPermissions();

        $hasAdminPermissions = $permissions->filter(function($item) use ($permission) {
            return str_contains($item->name, $permission.'.');
        });

        return $hasAdminPermissions->count() > 0;
    }

    public function getNationalNodesAttribute()
    {
        return $this->nodes->where('country.id', get_national_id());
    }

    public function getForeignNodesAttribute()
    {
        return $this->nodes->where('country.id', '!=', get_national_id());
    }
}
