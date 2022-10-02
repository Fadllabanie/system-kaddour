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
            Relation::make('provider_id')
                ->fromModel(Provider::class, 'first_name', 'id')
                ->empty(__('No select'))
                ->title(__('Provider')),

            Relation::make('category_id')
                ->fromModel(Category::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Category')), 
                
            Relation::make('product_id')
                ->fromModel(Product::class, 'name', 'id')
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
                ->title(__('price'))
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
            TD::make('product_id'),
            TD::make('category_id'),
            TD::make('provider_id'),

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
        $data = $this->calculation($request->all());
        
        
        $model->forceFill([
            'product_id' => $request->product_id,
            'provider_id' => $request->provider_id,
            'category_id' => $request->category_id,
        ])->save();
       
    }

    public function calculation($data)
    {
        $product = Product::with('provider')->find($data['product_id']);
        $product = AppSetting::first();

        if($data->type == '1'){ // خصم
            $newPrice = $product->price * 100 / $data['price'] ;
            $data['price'] = $product->price - $newPrice ;
        }elseif($data->type == '2'){ // اضافه 
            $newPrice = $product->price * 100 / $data['price'] ;
            $data['price']= $product->price + $newPrice ;
        }elseif($data->type == '3'){ // قيمه 
            $data['price'] = $product->price + $data['price'] ;
        }

        if($product->provider->currency == 'sp'){

        }elseif($product->provider->currency == '$'){

        }
        
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
