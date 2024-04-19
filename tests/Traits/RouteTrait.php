<?php

namespace Tests\Traits;

trait RouteTrait
{
    protected function routeAdminDashboardIndex(): string
    {
        return route('admin.dashboard.index');
    }

    protected function routeAdminLoginForm(): string
    {
        return route('admin.login.form');
    }

    public function routeAdminLoginHandler(): string
    {
        return route('admin.login.handler');
    }

}
