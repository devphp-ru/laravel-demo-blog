<?php

namespace Tests\Traits;

use App\Models\AdminUser;

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

    public function routeAdminLogout(): string
    {
        return route('admin.user.logout');
    }

    public function routeAdminUsersIndex(): string
    {
        return route('admin-users.index');
    }

    public function routeAdminUsersCreate(): string
    {
        return route('admin-users.create');
    }

    public function routeAdminUsersStore(): string
    {
        return route('admin-users.store');
    }

    public function routeAdminUsersEdit(AdminUser $item): string
    {
        return route('admin-users.edit', $item);
    }

    public function routeAdminUsersUpdate(AdminUser $item): string
    {
        return route('admin-users.update', $item);
    }

}
