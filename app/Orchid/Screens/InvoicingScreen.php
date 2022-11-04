<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use App\Models\Invoicing;
use App\Models\InvoicingProducts;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use App\Orchid\Layouts\Repeaters\RepeaterFields;
use Nakukryskin\OrchidRepeaterField\Fields\Repeater;

class InvoicingScreen extends Screen
{

    public  $invoicing;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Invoicing $invoicing): array
    {
        return [
            'invoicing' => $invoicing
        ];
    }


    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Advanced form controls';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Examples for creating a wide variety of forms.';
    }


    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::rows([

                Group::make([
                    Relation::make('client_id')
                        ->fromModel(Client::class, 'first_name', 'id')
                        ->empty(__('No select'))
                        ->title(__('Client')),

                    Select::make('currency')
                        ->title(__('Currency'))
                        ->options([
                            '$'   => '$',
                            'sp' => 'SP',
                        ]),

                    Select::make('payment_type')
                        ->title(__('payment type'))
                        ->options([
                            '1'   => 'اجيل',
                            '2' => 'تحويل',
                            '3' => 'نقدي',
                        ]),
                ]),

            ])->title('Input mask'),

            Layout::rows([
                Group::make([
                    Repeater::make('repeater')
                        ->title('Repeater')
                        ->layout(RepeaterFields::class),
                ]),
            ])
        ];
    }
    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('paper-plane')
                ->method('save')
        ];
    }

    public function save(Invoicing $invoicing, Request $request)
    {


        Invoicing::create([
            'client_id' => $request->client_id,
            'currency' => $request->currency,
            'payment_type' => $request->payment_type,
        ]);

        foreach ($request->repeater as $key => $value) {
            InvoicingProducts::create([
                'product_id' => $value['product_id'],
                'unit' => $value['unit'],
                'price' => $value['price'],
                'count' => $value['count'],
                'total' => (int)$value['count'] * (float)$value['price'],
            ]);
        }

        Alert::info('You have successfully created a invoicing.');

        return redirect()->route('platform.invoicing');
    }
}
