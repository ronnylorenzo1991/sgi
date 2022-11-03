<?php

use App\Models\Countries\Entity\country;

function get_national_id()
{
    return country::where('name', 'Cuba')->first()->id;
}
