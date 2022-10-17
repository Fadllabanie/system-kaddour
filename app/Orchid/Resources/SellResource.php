<?php

namespace App\Orchid\Resources;

use Orchid\Screen\TD;
use App\Models\Category;
use Orchid\Crud\Resource;
use App\Models\Provider;
use App\Models\Unit;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Illuminate\Database\Eloquent\Model;

class SellResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Sell::class;
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
            Relation::make('provider_id')
                ->fromModel(Provider::class, 'first_name', 'id')
                ->empty(__('No select'))
                ->searchColumns('first_name')
                ->title(__('Provider')),

            Relation::make('category_id')
                ->fromModel(Category::class, 'name', 'id')
                ->empty(__('No select'))
                ->searchColumns('name')
                ->title(__('Category')),

            Select::make('type_of_sell')
                ->title(__('Type Of Sell'))
                ->options([
                    '1'   => 'Product',
                    '2' => 'Money',
                ]),

            Input::make('amount')
                ->title(__('Amount'))
                ->type('number')
                ->placeholder(__('Enter amount here')),

            Relation::make('unit_id')
                ->fromModel(Unit::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Unit')),

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
            TD::make('code', __("Code")),
            TD::make('date', __("Date")),
            TD::make('provider_id', __("Provider"))
                ->render(function ($model) {
                    return $model->provider->first_name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

            TD::make('category_id', __("Category"))
                ->render(function ($model) {
                    return $model->category->name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),



            TD::make('type_of_sell', __("Type Of Sell"))
                ->render(function ($model) {

                    if ($model->type_of_sell == '1') { // مستهلك
                        return 'Product';
                    } elseif ($model->type_of_sell == '2') { // خاص 
                        return 'MOnty';
                    }
                }),
            TD::make('amount', __("amount")),

            TD::make('unit_id', __("Unit"))
                ->render(function ($model) {
                    return $model->unit->name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

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

    public function onSave(ResourceRequest $request, Model $model)
    {

        $model->forceFill([
            'code' => generateRandomCode('sell'),
            'date' => now(),
            'amount' => $request->amount,
            'unit_id' => $request->unit_id,
            'type_of_sell' => $request->type_of_sell,
            'provider_id' => $request->provider_id,
            'category_id' => $request->category_id,
        ])->save();
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
