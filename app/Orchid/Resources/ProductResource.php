<?php

namespace App\Orchid\Resources;

use App\Models\City;
use Orchid\Screen\TD;
use App\Models\Country;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Unit;
use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use Illuminate\Validation\Rule;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;
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
                ->title(__('Provider')),

            Relation::make('category_id')
                ->fromModel(Category::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Category')),

            Cropper::make('image')
                ->width(1000)
                ->height(500),

            Input::make('name')
                ->title(__('Name'))
                ->placeholder(__('Enter name here')),

            TextArea::make('description')
                ->rows(5),

            Input::make('version')
                ->title(__('Version'))
                ->placeholder(__('Enter version here')),

            Input::make('barcode')
                ->title(__('barcode'))
                ->placeholder(__('Enter barcode here')),

            Input::make('model')
                ->title(__('model'))
                ->placeholder(__('Enter model here')),

            Input::make('made')
                ->title(__('made'))
                ->placeholder(__('Enter made here')),

            Input::make('price')
                ->title(__('price'))
                ->type('number')
                ->placeholder(__('Enter price here')),

            Input::make('count')
                ->title(__('Count'))
                ->placeholder(__('Enter count here')),


            Relation::make('unit')
            ->fromModel(Unit::class, 'name', 'id')
            ->empty(__('No select'))
            ->title(__('Unit')),

            // Select::make('unit')
            //     ->title(__('Unit'))
            //     ->options([
            //         'kg'   => 'KG',
            //         'm' => 'M',
            //     ]),

            Select::make('currency')
                ->title(__('Currency'))
                ->options([
                    '$'   => '$',
                    'sp' => 'SP',
                ]),



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
            TD::make('id')
                ->width('150')
                ->render(function ($model) {
                    return "<img src='" . asset($model->image) . "'
                  alt='sample'
                  class='mw-100 d-block img-fluid'>";
                }),
            TD::make('name'),
            TD::make('provider_id', __("Provider"))
                ->render(function ($product) {
                    return $product->provider->first_name . " " . $product->provider->last_name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

            TD::make('category_id', __("Category"))
                ->render(function ($product) {
                    return $product->category->name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

            TD::make('price'),
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
            'name' => ['required'],
            'description' => ['required'],
            'unit' => ['required'],
            'price' => ['required'],
            'currency' => ['required'],
            'description' => ['required'],
            'count' => ['required'],
            'version' => ['required'],
            'barcode' => ['required'],
            'made' => ['required'],
            'model' => ['required'],
            'image' => ['required'],
            'provider_id' => ['required'],
            'category_id' => ['required'],

        ];
    }
    public function onSave(ResourceRequest $request, Model $model)
    {
        if(app()->environment('production')){
            $path =  'public/uploads/' . Hash::make('123') . '.jpg';
        }else{
            $path =  'uploads/' . Hash::make('123') . '.jpg';

        }
        $model->forceFill([
            'code' => generateRandomCode('PRO'),
            'name' => $request->name,
            'description' => $request->description,
            'unit' => $request->unit,
            'count' => $request->count,
            'model' => $request->model,
            'price' => $request->price,
            'currency' => $request->currency,
            'version' => $request->version,
            'barcode' => $request->barcode,
            'made' => $request->made,
            'provider_id' => $request->provider_id,
            'category_id' => $request->category_id,
            'image' => $path,
        ])->save();

        
        \File::copy(
            storage_path('/app' . substr($request->image, 8)),
            public_path($path)
        );
      
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
