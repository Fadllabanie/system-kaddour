<?php

namespace App\Orchid\Resources;

use Orchid\Screen\TD;
use App\Models\Product;
use Orchid\Crud\Resource;
use App\Models\Sell;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class ProductSellResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProductSell::class;
    public static function displayInNavigation(): bool
    {
        return false;
    }
    public static function perPage(): int
    {
        return 30;
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Relation::make('product_id')
                ->fromModel(Product::class, 'name', 'id')
                ->empty(__('No select'))
                ->searchColumns('name')
                ->title(__('product')),

            Relation::make('sell_id')
                ->fromModel(Sell::class, 'code', 'id')
                ->searchColumns('code')
                ->title(__('Sell')),


            Input::make('amount')
                ->title(__('Amount'))
                ->type('number')
                ->placeholder(__('Enter amount here')),

            Input::make('buy_bill')
                ->title(__('Buy Bill'))
                ->placeholder(__('Enter buy bill here')),

        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('sell_id', __("Sell"))
                ->render(function ($model) {
                    return $model->sell->code ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

            TD::make('product_id', __("Product"))
                ->render(function ($model) {
                    return $model->product->name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),


            TD::make('amount', __("Amount")),
            TD::make('buy_bill', __("Buy Bill")),
            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
