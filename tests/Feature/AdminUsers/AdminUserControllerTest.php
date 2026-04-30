<?php

declare(strict_types=1);

namespace Tests\Feature\AdminUsers;

use App\Models\AdminUser;
use App\Services\AdminUsers\AdminUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminUserControllerTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;

    public AdminUserService $adminUserService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->adminUserService = app()->make(AdminUserService::class);
    }

    public function test_get_response_from_admin_users_index(): void
    {
        $response = $this->get($this->routeAdminUsersIndex());

        $response->assertStatus(200);
    }

    public function test_get_view_admin_users_index(): void
    {
        $perPage = 10;
        $title = 'Администраторы';
        $request = new Request();

        $response = $this->get($this->routeAdminUsersIndex());
        $users = $this->adminUserService->getAllAdminsWithPagination($request, $perPage);

        $response->assertSuccessful();
        $response->assertViewIs('admin.admin_users.index');
        $response->assertViewHasAll([
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function test_get_view_show_user(): void
    {
        $user = AdminUser::factory()->create();
        $title = 'Профиль администратора';

        $response = $this->get($this->routeAdminUsersShow($user));

        $response->assertStatus(200);
        $response->assertViewIs('admin.admin_users.show');
        $response->assertViewHas([
            'title' => $title,
            'user' => $user,
        ]);
    }

    public function test_get_view_admin_users_create(): void
    {
        $title = 'Добавить';
        $response = $this->get($this->routeAdminUsersCreate());

        $response->assertSuccessful();
        $response->assertViewIs('admin.admin_users.create');
        $response->assertViewHasAll([
            'title' => $title,
        ]);
    }

    public function test_user_create(): void
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

        $this->assertDataBaseCount(AdminUser::class, 2);
        $this->assertDatabaseHas(AdminUser::class, [
            'username' => 'Test',
            'email' => 'test@example.com',
            'is_banned' => false,
        ]);
    }

    public function test_get_view_admin_users_edit(): void
    {
        $item = AdminUser::factory()->create();
        $title = 'Редактировать: ' . $item->username;

        $response = $this->get($this->routeAdminUsersEdit($item));

        $response->assertViewIs('admin.admin_users.edit');
        $response->assertViewHas([
            'title' => $title,
            'item' => $item,
        ]);
    }

    public function test_user_update(): void
    {
        $item = AdminUser::factory()->create([
            'username' => 'Test',
            'email' => 'test@example.com',
            'is_banned' => false,
        ]);

        $response = $this->put($this->routeAdminUsersUpdate($item), [
            'username' => 'Admin',
            'email' => 'admim@example.com',
            'password' => '12345j',
            'password_confirmation' => '12345j',
            'is_banned' => true,
        ]);

        $users = AdminUser::get();
        $user = $users->first();

        $response->assertRedirect($this->routeAdminUsersIndex());
        $response->assertSessionHas([
            'success' => 'Успешно сохранено.',
        ]);

        $this->assertDatabaseCount(AdminUser::class, 2);
        $this->assertDatabaseHas(AdminUser::class,  [
            'username' => 'Admin',
            'email' => 'admim@example.com',
            'is_banned' => 1,
        ]);

        $this->assertFalse(Hash::check($item->password, $user->password));
    }

    public function test_user_delete(): void
    {
        $item = AdminUser::factory()->create();

        $response = $this->delete($this->routeAdminUsersDestroy($item));
        $user = AdminUser::find($item->id);

        $response->assertRedirect($this->routeAdminUsersIndex());
        $response->assertSessionHas([
            'success' => 'Успешно удалено.',
        ]);

        $this->assertNull($user);
        $this->assertDatabaseCount(AdminUser::class, 1);
    }

}
