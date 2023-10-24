<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())->extraAttributes([
                'class' => 'cursor-pointer',
                'onClick' => "window.location.href='/admin/users'",
            ]),
            Stat::make('News', News::count())->extraAttributes([
                'class' => 'cursor-pointer',
                'onClick' => "window.location.href='/admin/news'",
            ]),
        ];
    }
}
