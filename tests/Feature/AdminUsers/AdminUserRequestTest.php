<?php

namespace Tests\Feature\AdminUsers;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminUserRequestTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
    }

    public function testUserValidateWithEmptyFields(): void
    {
        $this->post($this->routeAdminUsersStore(), [
            'username' => '',
            'email' => '',
            'password' => '',
        ])->assertInvalid([
            'username' => 'Поле Имя обязательно.',
            'email' => 'Поле Email обязательно.',
            'password' => 'Поле Пароль обязательно.',
        ]);

        $this->assertFalse(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserRegisterIncorrectData(): void
    {
        $this->post($this->routeAdminUsersStore(), [
            'username' => 'invalid-name',
            'email' => 'test-example.com',
            'password' => '!@#12345j',
            'password_confirmation' => '!@#12345j',
        ])->assertInvalid([
            'username' => 'Значение поля Имя имеет некорректный формат.',
            'email' => 'Значение поля Email должно быть действительным электронным адресом',
            'password' => 'Значение поля Пароль имеет некорректный формат.',
        ]);

        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserValidateWithExistingEmail(): void
    {
        $this->actingAs(AdminUser::factory()->create([
            'email' => 'test@example.com',
        ]), 'admin')->post($this->routeAdminUsersStore(), [
            'username' => 'Test',
            'email' => 'test@example.com',
            'password' => '12345j',
            'password_confirmation' => '12345j',
        ])->assertInvalid([
            'email' => 'Такое значение поля Email уже существует.',
        ]);

        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

}
