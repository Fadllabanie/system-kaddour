<?php

namespace App\Orchid\Resources;

use Orchid\Screen\TD;
use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Illuminate\Database\Eloquent\Model;

class TagResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Tag::class;
    public static function displayInNavigation(): bool
    {
        return true;
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
            TD::make('name',__("Name"))->sort()->filter(TD::FILTER_TEXT),

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
        return [
            Sight::make('id'),
            Sight::make('name'),
        ];
    }
    public function rules(Model $model): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(self::$model, 'name')->ignore($model),
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
