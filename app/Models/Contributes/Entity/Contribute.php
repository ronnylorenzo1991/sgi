<?php

namespace App\Models\Contributes\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
}
