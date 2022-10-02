<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;

    public $guarded = [];
    use AsSource, Filterable, Attachable;

    protected $allowedFilters = [
        'id',
        'first_name',
        'email',
        'mobile',
        'phone',
        'tel',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'first_name',
        'email',
        'mobile',
        'phone',
        'tel',
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
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }
}