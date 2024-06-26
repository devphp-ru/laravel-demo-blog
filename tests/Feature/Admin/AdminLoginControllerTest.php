<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminLoginControllerTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;

    public function testGetAResponseFromLoginForm(): void
    {
        $response = $this->get($this->routeadminLoginForm());

        $response->assertStatus(200);
    }

    public function testGetViewLoginForm(): void
    {
        $response = $this->get($this->routeAdminLoginForm());

        $response->assertSuccessful();
        $response->assertViewIs('auth.admin_login_form');
    }

    public function testCanUserLoginWithIncorrectEmail(): void
    {
        $response = $this->from($this->routeAdminLoginForm())->post($this->routeAdminLoginHandler(), [
            'email' => 'invalid-email.ru',
            'password' => '12345j',
        ]);

        $response->assertRedirect($this->routeAdminLoginForm());
        $response->assertSessionHasErrors([
            'email' => 'Значение поля Email должно быть действительным электронным адресом.',
        ]);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest('admin');
    }

    public function testCanUserLoginWithIncorrectPassword(): void
    {
        $response = $this->from($this->routeAdminLoginForm())->post($this->routeAdminLoginHandler(), [
            'email' => 'test@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->routeAdminLoginForm());
        $response->assertSessionHasErrors([
            'error' => 'Неверный логин или пароль.',
        ]);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserLoginCannotLoginWithEmailThatDoesNotExist(): void
    {
        AdminUser::factory()->create();

        $response = $this->from($this->routeAdminLoginForm())->post($this->routeAdminLoginHandler(), [
            'email' => 'test@example.ru',
            'password' => '12345j',
        ]);

        $response->assertRedirect($this->routeAdminLoginForm());
        $response->assertSessionHasErrors([
            'error' => 'Неверный логин или пароль.',
        ]);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserCannotLoginWithIsBanned(): void
    {
        $item = AdminUser::factory()->create([
            'is_banned' => true,
        ]);

        $response = $this->from($this->routeAdminLoginForm())->post($this->routeAdminLoginHandler(), [
            'email' => $item->email,
            'password' => '12345j',
        ]);

        $response->assertRedirect($this->routeAdminLoginForm());
        $response->assertSessionHasErrors([
            'error' => 'Доступ запрещен.',
        ]);
        $this->assertFalse(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest('admin');
    }

    public function testCanUserLoginWithCorrectCredentials(): void
    {
        $item = AdminUser::factory()->create();

        $response = $this->from($this->routeAdminLoginForm())->post($this->routeAdminLoginHandler(), [
            'email' => $item->email,
            'password' => '12345j',
        ]);
        $user = auth('admin')->user();

        $response->assertRedirect($this->routeAdminDashboardIndex());
        $this->assertAuthenticated('admin');
        $this->assertAuthenticatedAs($user, 'admin');
        $response->assertSessionHas([
            'success' => 'Вы вошил в систему.',
        ]);
        $this->assertSame($item->id, $user->id);
        $this->assertSame($item->username, $user->username);
        $this->assertSame($item->email, $item->email);
        $this->assertFalse($user->is_banned);
    }

    public function testCanUserLogout(): void
    {
        $item = AdminUser::factory()->create();
        $this->be($item, 'admin');

        $response = $this->get($this->routeAdminLogout());

        $response->assertRedirect($this->routeAdminLoginForm());
        $response->assertSessionHas([
            'success' => 'Вы вышил из системы.',
        ]);
        $this->assertGuest('admin');
    }

}
