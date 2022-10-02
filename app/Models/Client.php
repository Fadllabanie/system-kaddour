<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    public $guarded = [];
    protected $allowedFilters = [
        'id',
        'first_name',
        'email',
        'mobile',
        'phone',
        'tel',
        'category_id',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'first_name',
        'email',
        'mobile',
        'phone',
        'tel',
        'category_id',
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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
