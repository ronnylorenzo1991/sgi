<?php

namespace App\Models\Subcategories\Entity;

use App\Models\Categories\Entity\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Subcategory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'description',
        'status',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
