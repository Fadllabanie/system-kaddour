<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            // Menu::make('Example screen')
            //     ->icon('monitor')
            //     ->route('platform.example')
            //     ->title('Navigation')
            //     ->badge(function () {
            //         return 6;
            //     }),

            // Menu::make('Dropdown menu')
            //     ->icon('code')
            //     ->list([
            //         Menu::make('Sub element item 1')->icon('bag'),
            //         Menu::make('Sub element item 2')->icon('heart'),
            //     ]),

            // Menu::make('Basic Elements')
            //     ->title('Form controls')
            //     ->icon('note')
            //     ->route('platform.example.fields'),

            // Menu::make('Advanced Elements')
            //     ->icon('briefcase')
            //     ->route('platform.example.advanced'),

            // Menu::make('Text Editors')
            //     ->icon('list')
            //     ->route('platform.example.editors'),

            // Menu::make('Overview layouts')
            //     ->title('Layouts')
            //     ->icon('layers')
            //     ->route('platform.example.layouts'),

            Menu::make('Chart tools')
                ->icon('bar-chart')
                ->route('platform.example.charts'),

            // Menu::make('Cards')
            //     ->icon('grid')
            //     ->route('platform.example.cards')
            //     ->divider(),

            // Menu::make('Documentation')
            //     ->title('Docs')
            //     ->icon('docs')
            //     ->url('https://orchid.software/en/docs'),

            // Menu::make('Changelog')
            //     ->icon('shuffle')
            //     ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
            //     ->target('_blank')
            //     ->badge(function () {
            //         return Dashboard::version();
            //     }, Color::DARK()),


            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

            Menu::make('Location')
                ->icon('anchor')
                ->list([
                    Menu::make(__("Countries"))->url('/admin/crud/list/country-resources')->icon('bag'),
                    Menu::make(__('Cities'))->url('/admin/crud/list/city-resources')->icon('bag'),
                    Menu::make(__('Location'))->url('/admin/crud/list/location-resources')->icon('bag'),

                ]),

            Menu::make('General')
                ->icon('directions')
                ->list([
                    Menu::make(__('Client Type'))->url('/admin/crud/list/client-type-resources')->icon('bag'),
                    Menu::make(__('Location'))->url('/admin/crud/list/location-resources')->icon('bag'),
                ]),

            Menu::make('Users')
                ->icon('people')
                ->list([
                    Menu::make(__("Providers"))->url('/admin/crud/list/provider-resources')->icon('bag'),
                    Menu::make(__('Clients'))->url('/admin/crud/list/client-resources')->icon('bag'),
                ]),

            Menu::make('Products')
                ->icon('organization')
                ->list([
                    Menu::make(__("Products"))->url('/admin/crud/list/product-resources')->icon('bag')->name('products'),
                    Menu::make(__('Categories'))->url('/admin/crud/list/category-resources')->icon('bag'),
                    Menu::make(__("Unit"))->url('/admin/crud/list/unit-resources')->icon('bag'),

                ]),
            Menu::make('Prices')
                ->icon('wallet')
                ->list([
                    Menu::make(__("Products Price"))->url('/admin/crud/list/product-price-resources')->icon('bag'),
                    Menu::make(__('Categories Price'))->url('/admin/crud/list/category-price-resources')->icon('bag'),

                ]),
                
            Menu::make('Purchases')
                ->icon('wallet')
                ->list([
                    Menu::make(__("Purchases"))->url('/admin/crud/list/sell-resources')->icon('bag'),
                    Menu::make(__("Product Purchases"))->url('/admin/crud/list/product-sell-resources')->icon('bag'),

                ]),

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
