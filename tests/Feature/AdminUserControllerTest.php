<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
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
        $response = $this->actingAs(AdminUser::factory()->create(), 'admin')
            ->post($this->routeAdminUsersStore(), [
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

    public function testGetViewAdminUsersEdit(): void
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

    public function testUserUpdate(): void
    {
        $this->withoutMiddleware();

        $item = AdminUser::factory()->create([
            'username' => 'Test',
            'email' => 'test@example.com',
            'is_banned' => false,
        ]);

        $response = $this->actingAs($item, 'admin')
            ->put($this->routeAdminUsersUpdate($item), [
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
        $this->assertDatabaseCount(AdminUser::class, 1);
        $this->assertDatabaseHas(AdminUser::class,  [
            'username' => 'Admin',
            'email' => 'admim@example.com',
            'is_banned' => 1,
        ]);
        $this->assertFalse(Hash::check($item->password, $user->password));
    }

    public function testUserDelete(): void
    {
        $item = AdminUser::factory()->create();

        $response = $this->delete($this->routeAdminUsersDestroy($item));
        $user = AdminUser::find($item->id);

        $response->assertRedirect($this->routeAdminUsersIndex());
        $response->assertSessionHas([
            'success' => 'Успешно удалено.',
        ]);
        $this->assertNull($user);
        $this->assertDatabaseCount(AdminUser::class, 0);
    }

}
