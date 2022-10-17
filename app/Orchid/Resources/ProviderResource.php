<?php

namespace App\Orchid\Resources;

use App\Models\City;
use Orchid\Screen\TD;
use App\Models\Country;
use App\Models\Location;
use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use App\Models\ClientType;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Input;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class ProviderResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Provider::class;
    public static function displayInNavigation(): bool
    {
        return false;
    }
    public static function perPage(): int
    {
        return 30;
    }
    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function fields(): array
    {
        return [

            Cropper::make('logo')
            ->title('Large web banner image, generally in the front and center')
            ->width(1000)
            ->height(500),

            Input::make('first_name')
                ->title(__('First Name'))
                ->placeholder(__('Enter first name here')),
            Input::make('last_name')
                ->title(__('Last Name'))
                ->placeholder(__('Enter last name here')),

            Input::make('email')
                ->title(__('Email'))
                ->placeholder(__('Enter email here')),
            Input::make('password')
                ->type('password')
                ->title(__('password'))
                ->placeholder(__('Enter password here')),
            Input::make('mobile')
                ->type('tel')

                ->title(__('mobile'))
                ->placeholder(__('Enter mobile here')),

            Input::make('phone')
                ->type('tel')

                ->title(__('phone'))
                ->placeholder(__('Enter phone here')),


            Input::make('tel')
                ->type('tel')
                ->title(__('tel'))
                ->placeholder(__('Enter telephone here')),

            Input::make('whatsapp')
                ->type('tel')
                ->title(__('Whatsapp'))
                ->placeholder(__('Enter whatsapp here')),

            Input::make('website')
                ->type('url')
                ->title(__('website'))
                ->placeholder(__('Enter website here')),

            Input::make('address')
                ->title(__('address'))
                ->placeholder(__('Enter address here')),

            Select::make('currency')
                ->title(__('Currency'))
                ->options([
                    '$'   => '$',
                    'sp' => 'SP',
                ]),

            Input::make('dealing_way')
                ->title(__('dealing_way'))
                ->placeholder(__('Enter dealing way here')),

            Input::make('dealing_number')
                ->title(__('dealing_number'))
                ->placeholder(__('Enter dealing number here')),


            Relation::make('client_type_id')
                ->fromModel(ClientType::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Client Type')),

            Relation::make('city_id')
                ->fromModel(City::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('City')),

            Relation::make('country_id')
                ->fromModel(Country::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Country')),

            Relation::make('location_id')
                ->fromModel(Location::class, 'name', 'id')
                ->empty(__('No select'))
                ->title(__('Location')),

            Map::make('place')
                ->title('Map')
                ->help('Enter the coordinates, or use the search'),

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
                ->render(function ($model) {
                    return "<img src='" . url($model->logo) . "'
                      alt='sample'
                      class='mw-100 d-block img-fluid rounded-1 w-100'>";
                }),
            TD::make('first_name', __('Named'))
                ->render(function ($model) {
                    return $model->first_name . ' ' . $model->last_name;
                })->sort()->filter(TD::FILTER_TEXT),
            TD::make('email', __('Email'))->sort()->filter(TD::FILTER_TEXT),
            TD::make('mobile', __('Mobile'))->sort()->filter(TD::FILTER_TEXT),
            TD::make('phone', __('Phone'))->sort()->filter(TD::FILTER_TEXT),
            TD::make('tel', __('Telephone'))->sort()->filter(TD::FILTER_TEXT),
            TD::make('client_type_id', __("Client Type"))
                ->render(function ($client) {
                    return $client->clientType->name ?? "";
                })
                ->sort()->filter(TD::FILTER_SELECT),
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
            Sight::make('first_name'),
            Sight::make('email'),
            Sight::make('mobile'),
            Sight::make('phone'),
        ];
    }
    public function rules(Model $model): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'mobile' => ['required'],
            'phone' => ['required'],
            'tel' => ['required'],
            'country_id' => ['required'],
            'city_id' => ['required'],
            'location_id' => ['required'],
            'address' => ['required'],
            'client_type_id' => ['required'],
            'currency' => ['required'],
            'dealing_way' => ['required'],
            'dealing_number' => ['required'],
            'website' => ['required'],
            'logo' => ['required'],
            'whatsapp' => ['required'],
        ];
    }
    public function onSave(ResourceRequest $request, Model $model)
    {
        $path =  'uploads/' . Hash::make('123') . '.jpg';

        $model->forceFill([
            'code' => generateRandomCode('CLI'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'currency' => $request->currency,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'tel' => $request->tel,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'lat' => $request->place['lat'],
            'lng' => $request->place['lng'],
            'client_type_id' => $request->client_type_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'location_id' => $request->location_id,
            'dealing_way' => $request->dealing_way,
            'dealing_number' => $request->dealing_number,
            'website' => $request->website,
            'logo' => $path,
            'whatsapp' => $request->whatsapp,
        ])->save();
        
        \File::copy(
            storage_path('/app' . substr($request->logo, 8)),
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
