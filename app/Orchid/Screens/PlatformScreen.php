<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\ChartsLayout;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;

class PlatformScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Get Started !!';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Welcome to your Orchid application.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            // Link::make('Website')
            //     ->href('http://orchid.software')
            //     ->icon('globe-alt'),

            // Link::make('Documentation')
            //     ->href('https://orchid.software/en/docs')
            //     ->icon('docs'),

            // Link::make('GitHub')
            //     ->href('https://github.com/orchidsoftware/platform')
            //     ->icon('social-github'), 

            Button::make(__('Language'))
                ->icon('actual-size')
                ->method('changeLanguage'),

        ];
    }

    public function changeLanguage()
    {
       
        $locale = app()->getLocale();
        
        if ($locale == 'en') {
            $locale ='ar';
            app()->setLocale($locale);
           // dd($locale);
        }else{
            app()->setLocale($locale);

        }
       
        session()->put('locale', $locale);

    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            //  Layout::view('platform::partials.welcome'),
        ];
    }
}
