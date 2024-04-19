<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminUserControllerTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testGetAResponseFromAdminUsersIndex(): void
    {
        $response = $this->get($this->routeAdminUsersIndex());

        $response->assertStatus(200);
    }

    public function testGetViewAdminUsersIndex(): void
    {
        $title = 'Администраторы';
        $response = $this->get($this->routeAdminUsersIndex());
        $users = AdminUser::orderByDesc('id')->paginate(10);

        $response->assertSuccessful();
        $response->assertViewIs('admin.admin_users.index');
        $response->assertViewHasAll([
            'title' => $title,
            'paginator' => $users,
        ]);
    }

}
