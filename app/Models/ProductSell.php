<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSell extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    public $guarded = [];

    public function sell()
    {
        return $this->belongsTo(Sell::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
