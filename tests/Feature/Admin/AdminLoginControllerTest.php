<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminLoginControllerTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;

    public function test_get_response_from_login_form(): void
    {
        $response = $this->get($this->routeadminLoginForm());

        $response->assertStatus(200);
    }

    public function test_get_view_login_form(): void
    {
        $response = $this->get($this->routeAdminLoginForm());

        $response->assertSuccessful();
        $response->assertViewIs('auth.admin_login_form');
    }

    public function test_can_user_login_with_incorrect_email(): void
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

    public function test_can_user_login_with_incorrect_password(): void
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

    public function test_user_login_cannot_login_with_email_that_does_not_exist(): void
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

    public function test_user_cannot_login_with_is_banned(): void
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

    public function test_can_user_login_with_correct_credentials(): void
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

    public function test_can_user_logout(): void
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
