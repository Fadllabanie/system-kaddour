<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    use AsSource, Filterable, Attachable;

    public $guarded = [];

    protected $allowedFilters = [
        'id',
        'Name',
        'city_id',
        'country_id',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'Name',
        'city_id',
        'country_id',
        'updated_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
