<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    use AsSource, Filterable, Attachable;

    public $guarded = [];

    protected $allowedFilters = [
        'id',
        'Name',
        'updated_at',
    ];

    protected $allowedSorts = [
        'id',
        'Name',
        'updated_at',
    ];

    public function getFullAttribute(): string
    {
        return $this->attributes['name'] . ' price (' . $this->attributes['price'] . ')';
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id','unit');
    }
}
