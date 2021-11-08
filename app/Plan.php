<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'plan_name',
        'slug',
        'stripe_plan',
        'product_id',
        'price',
        'duration',
        'stripe_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
