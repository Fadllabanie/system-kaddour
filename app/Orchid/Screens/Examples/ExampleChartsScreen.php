<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPercentageExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ExampleChartsScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'charts' => [
                [
                    'name'   => 'Some Data',
                    'values' => [1, 40, 30, 35],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Another Set',
                    'values' => [1, 50, -10, 15],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Yet Another',
                    'values' => [1, 20, -3, -15],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'And Last',
                    'values' => [1  , 33, -8, -3],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
            ],
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Charts';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return string[]|\Orchid\Screen\Layout[]
     *
     */
    public function layout(): iterable
    {
        return [
            // Layout::columns([
            //     ChartLineExample::class,
            //     ChartBarExample::class,
            // ]),

            Layout::columns([
                ChartPercentageExample::class,
                ChartPieExample::class,
            ]),
        ];
    }
}
