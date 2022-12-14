<?php

namespace App\Orchid\Resources;

use Orchid\Screen\TD;
use App\Models\Product;
use App\Models\Category;
use App\Models\Provider;
use Orchid\Crud\Resource;
use App\Models\AppSetting;
use App\Models\ProductPrice;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Illuminate\Database\Eloquent\Model;

class ProductPriceResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProductPrice::class;
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
            // Relation::make('provider_id')
            //     ->fromModel(Provider::class, 'first_name', 'id')
            //     ->empty(__('No select'))
            //     ->title(__('Provider')),

            // Relation::make('category_id')
            //     ->fromModel(Category::class, 'name', 'id')
            //     ->empty(__('No select'))
            //     ->title(__('Category')),

            Relation::make('product_id')
                ->fromModel(Product::class, 'name', 'id')
                ->displayAppend('full')
                ->searchColumns('name')
                ->empty(__('No select'))
                ->title(__('Product')),

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

            TD::make('product_id', __("Category"))
                ->render(function ($model) {
                    return $model->product->name ?? "";
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
            TD::make('price_in_sp'),

            TD::make('price_in_dollar'),

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
        //dd($request->all());
        $price = $this->calculation($request->all());
        $appSetting = AppSetting::first();
        $product = Product::with('provider')->find($request['product_id']);

        // if ($request->price_type == '1') { // مستهلك
            $model->updateOrCreate([
                'product_id' => $request->product_id,
                'provider_id' => $product->provider_id,
                'category_id' => $product->category_id,
                'type' => $request->price_type,
                'price_in_sp' => $price,
                'price_in_dollar' => $price / $appSetting->dollar,

            ])->save();
        // } elseif ($request->price_type == '2') { // خاص 
        //     $model->forceFill([
        //         'product_id' => $request->product_id,
        //         'provider_id' => $request->provider_id,
        //         'category_id' => $request->category_id,
        //         'special_price_in_sp' => $price,
        //         'special_price_in_dollar' => $price / $appSetting->dollar,

        //     ])->save();
        // } elseif ($request->price_type == '3') { // جمله 
        //     $model->forceFill([
        //         'product_id' => $request->product_id,
        //         'provider_id' => $request->provider_id,
        //         'category_id' => $request->category_id,
        //         'consumer_price_in_sp' => $price,
        //         'consumer_price_in_dollar' => $price / $appSetting->dollar,

        //     ])->save();


        //     $model->update([
        //         'quantity_price_in_sp' => $price,
        //         'quantity_price_in_dollar' => $price / $appSetting->dollar,
        //     ]);
        // } elseif ($request->price_type == '4') { // نصف جمله 
        //     $model->forceFill([
        //         'product_id' => $request->product_id,
        //         'provider_id' => $request->provider_id,
        //         'category_id' => $request->category_id,
        //         'half_quantity_price_in_sp' => $price,
        //         'half_quantity_price_in_dollar' => $price / $appSetting->dollar,

        //     ])->save();
        // } elseif ($request->price_type == '5') { // مفرق 
        //     $model->forceFill([
        //         'product_id' => $request->product_id,
        //         'provider_id' => $request->provider_id,
        //         'category_id' => $request->category_id,
        //         'sale_price_in_sp' => $price,
        //         'sale_price_in_dollar' => $price / $appSetting->dollar,

        //     ])->save();
       // }
    }

    public function calculation($data)
    {
        $product = Product::with('provider')->find($data['product_id']);

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
