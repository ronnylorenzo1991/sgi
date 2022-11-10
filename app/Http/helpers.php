<?php

use App\Models\Countries\Entity\country;
use \App\Models\Categories\Entity\Category;
function get_national_id()
{
    return country::where('name', 'Cuba')->first()->id;
}

function get_trojan_category_id()
{
    return Category::where('name', 'Programas malignos')->first()->id;
}

function real_empty($value)
{
    if (empty($value)) {
        return true;
    }

    if (
        ($value instanceof Collection || $value instanceof \Illuminate\Database\Eloquent\Collection)
        && $value->isEmpty()
    ) {
        return true;
    }

    return false;
}
