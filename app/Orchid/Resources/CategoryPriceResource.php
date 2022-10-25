<?php

namespace App\Orchid\Resources;

use Orchid\Screen\TD;
use App\Models\Product;
use App\Models\Category;
use Orchid\Crud\Resource;
use App\Models\AppSetting;
use App\Models\CategoryPrice;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Illuminate\Database\Eloquent\Model;

class CategoryPriceResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CategoryPrice::class;
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
            Relation::make('category_id')
                ->fromModel(Category::class, 'name', 'id')
                ->empty(__('No select'))
                ->searchColumns('name')
                ->title(__('Category')),


            Select::make('type')
                ->title(__('Type'))
                ->options([
                    '1'   => 'خصم',
                    '2' => 'اضافه',
                    '3' => 'قيمه',
                ]),

            Select::make('price_type')
                ->title(__('Price Type'))
                ->options([
                    '1'   => 'مستهلك',
                    '2' => 'خاص',
                    '3' => 'جمله',
                    '4' => 'نصف جمله',
                    '5' => 'مفرق',
                ]),

            Input::make('price')
                ->title(__('News Price'))
                ->type('number')
                ->placeholder(__('Enter price here')),
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

            TD::make('category_id', __("Category"))
                ->render(function ($model) {
                    return $model->category->name ?? "";
                })->sort()->filter(TD::FILTER_SELECT),

            TD::make('type', __("type"))
                ->render(function ($model) {

                    if ($model->type == '1') { // مستهلك
                        return 'مستهلك';
                    } elseif ($model->type == '2') { // خاص 
                        return 'خاص';
                    } elseif ($model->type == '3') { // جمله 
                        return 'جمله';
                    } elseif ($model->type == '4') { // نصف جمله 
                        return 'نصف جمله';
                    } elseif ($model->type == '5') { // مفرق 
                        return 'مفرق';
                    }
                }),
            TD::make('price_in_sp', __("price in sp")),

            TD::make('price_in_dollar', __("price in dollar")),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

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
        $products = Product::with('provider')->where('category_id', $request['category_id'])->get();

        foreach ($products as $key => $product) {

            $price = $this->calculation($request->all(), $product);

            $appSetting = AppSetting::first();

            $model->create([
                'provider_id' => $product->provider_id,
                'category_id' => $product->category_id,
                'type' => $request->price_type,
                'price_in_sp' => $price,
                'price_in_dollar' => $price / $appSetting->dollar,
            ]);
        }
    }

    public function calculation($data, $product)
    {

        if ($data['type'] == '1') { // خصم
            $newPrice = $product->price * $data['price'] / 100;
            $data['price'] = $product->price - $newPrice;
        } elseif ($data['type'] == '2') { // اضافه 
            $newPrice = $product->price * $data['price'] / 100;
            $data['price'] = $product->price + $newPrice;
        } elseif ($data['type'] == '3') { // قيمه 
            $data['price'] = $product->price + $data['price'];
        }

        return $data['price'];
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
