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

    public function testGetViewAdminUsersCreate(): void
    {
        $title = 'Добавить';
        $response = $this->get($this->routeAdminUsersCreate());

        $response->assertSuccessful();
        $response->assertViewIs('admin.admin_users.create');
        $response->assertViewHasAll([
            'title' => $title,
        ]);
    }

    public function testUserCreate(): void
    {
        $response = $this->post($this->routeAdminUsersStore(), [
            'username' => 'Test',
            'email' => 'test@example.com',
            'password' => '12345j',
            'password_confirmation' => '12345j',
            'is_banned' => false,
        ]);

        $response->assertRedirect($this->routeAdminUsersIndex());
        $response->assertSessionHas([
            'success' => 'Успешно сохранено.',
        ]);
        $this->assertDataBaseCount(AdminUser::class, 1);
        $this->assertDatabaseHas(AdminUser::class, [
            'username' => 'Test',
            'email' => 'test@example.com',
            'is_banned' => false,
        ]);
    }

}
