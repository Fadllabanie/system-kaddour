<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    public $guarded = [];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    } 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
