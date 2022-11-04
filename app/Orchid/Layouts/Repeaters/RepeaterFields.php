<?php

namespace App\Orchid\Layouts\Repeaters;

use App\Models\Unit;
use App\Models\Product;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;

class RepeaterFields extends Rows
{
    function fields(): array
    {
        return [
            Relation::make('product_id')
                ->fromModel(Product::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('product')),

            Relation::make('unit')
                ->fromModel(Unit::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Unit')),

            Input::make('count')
                ->title(__('Count'))
                ->placeholder(__('Enter count here')),

            Input::make('price')
                ->title(__('price'))
                ->type('number')
                ->placeholder(__('Enter price here')),
        ];
    }
}
