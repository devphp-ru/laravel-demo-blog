<?php

namespace Tests\Feature\Admin\Users;

use App\Models\AdminUser;
use App\Models\User;
use App\Services\Users\UserRepository;
use App\Services\Users\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public UserService $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->userService = new UserService(new UserRepository());
    }

    public function testGetViewUsersIndex(): void
    {
        User::factory(25)->create();
        $title = 'Пользователи';
        $perPage = 10;
        $request = new Request();

        $response = $this->get(route('users.index'));
        $users = $this->userService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewhas([
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function testGetViewUsersCreate(): void
    {
        $title = 'Добавить';

        $response = $this->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
        $response->assertViewHas([
            'title' => $title,
        ]);
    }

    public function testCanUserCreate(): void
    {
        $response = $this->post(route('users.store'), [
            'name' => 'Test Test',
            'email' => 'test@example.com',
            'password' => '12345j',
            'password_confirmation' => '12345j',
            'is_banned' => '0',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas([
            'success' => 'Успешно сохранено.',
        ]);
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseHas(User::class, [
            'name' => 'Test Test',
            'email' => 'test@example.com',
            'is_banned' => '0',
        ]);
    }

    public function testGetViewUserEdit(): void
    {
        $item = User::factory()->create();
        $title = 'Редактировать: ' . $item->name;

        $response = $this->get(route('users.edit', $item));

        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas([
            'title' => $title,
            'item' => $item,
        ]);
    }

    public function testCanUserUpdate(): void
    {
        $item = User::factory()->create();

        $response = $this->put(route('users.update', $item), [
            'name' => 'Test Test',
            'email' => 'test@example.com',
            'is_banned' => '1',
        ]);
        $user = User::get()->first();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseHas(User::class, [
            'name' => 'Test Test',
            'email' => 'test@example.com',
            'is_banned' => '1',
        ]);
        $this->assertTrue(Hash::check('12345j', $user->password));
    }

    public function testCanUserDelete(): void
    {
        $item = User::factory()->create();

        $response = $this->delete(route('users.destroy', $item));
        $users = User::get();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Успешно удалено.');
        $this->assertDatabaseCount(User::class, 0);
        $this->assertTrue($users->isEmpty());
    }

}
