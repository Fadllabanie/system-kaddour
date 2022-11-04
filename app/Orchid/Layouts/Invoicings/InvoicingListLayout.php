<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Invoicings;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class InvoicingListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'invoicings';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('client_id', __("Client"))
            ->render(function ($invoicing) {
                return $invoicing->client->first_name ;
            })->sort()->filter(TD::FILTER_SELECT),

            TD::make('currency'),
            TD::make('payment_type'),

         
            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function ($invoicing) {
                    return $invoicing->updated_at->toDateTimeString();
                }),

         
            ];
    }
}
