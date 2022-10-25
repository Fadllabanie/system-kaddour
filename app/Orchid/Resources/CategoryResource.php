<?php

namespace App\Orchid\Resources;

use App\Models\Category;
use Orchid\Screen\TD;
use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Relation;
use Illuminate\Database\Eloquent\Model;

class CategoryResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;
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
            Relation::make('parent_id')
                ->fromModel(Category::class, 'name', 'id')
                ->title(__('Parent')),
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
            TD::make('parent_id', __("Category"))
                ->render(function ($category) {
                    return $category->parent->name ?? "";
                })
                ->sort()->filter(TD::FILTER_SELECT),

            TD::make('updated_at', __('Update date'))->sort()
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

    public function onSave(ResourceRequest $request, Model $model)
    {

        $model->forceFill([
            'code' => generateRandomCode('CAT'),
            'name' => $request->name,
            'parent_id' => $request->parent_id == null ? 0 : $request->parent_id,
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
