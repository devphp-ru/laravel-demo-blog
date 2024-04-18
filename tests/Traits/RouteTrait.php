<?php

namespace Tests\Traits;

trait RouteTrait
{
    protected function routeAdminDashboardIndex(): string
    {
        return route('admin.dashboard.index');
    }

}
