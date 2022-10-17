<?php

namespace App\Orchid\Resources;

use App\Models\City;
use App\Models\Country;
use Orchid\Screen\TD;
use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Illuminate\Database\Eloquent\Model;

class LocationResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Location::class;
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
            Input::make('name')
                ->title(__('Name'))
                ->placeholder(__('Enter name here')),

            Relation::make('city_id')
                ->fromModel(City::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('City')),

            Relation::make('country_id')
                ->fromModel(Country::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Country')),
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
            TD::make('id')->sort(),
            TD::make('name', __("Name"))->sort()->filter(TD::FILTER_TEXT),
            TD::make('city_id', __("City"))
                ->render(function ($location) {
                    return $location->city->name ?? "";
                })
                ->sort()->filter(TD::FILTER_SELECT),

            TD::make('country_id', __("Country"))
                ->render(function ($location) {
                    return $location->country->name ?? "";
                })
                ->sort()->filter(TD::FILTER_SELECT),

            TD::make('updated_at', 'Update date')->sort()
                ->render(function ($model) {
                    return $model->updated_at->diffForHumans();
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
        return [
            Sight::make('id'),
            Sight::make(__('name')),
        ];
    }

    public function rules(Model $model): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(self::$model, 'name')->ignore($model),
            ],
            'city_id' => [
                'required',
            ],
            'country_id' => [
                'required',
            ],
        ];
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
