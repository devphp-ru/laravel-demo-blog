<?php

namespace Tests\Feature\Admin\Users;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
    }

    public function testUserValidateWithEmptyFields(): void
    {
        $this->post(route('users.store'), [
            'name' => '',
            'email' => '',
            'password' => '',
        ])->assertInvalid([
            'name' => 'Поле Имя обязательно.',
            'email' => 'Поле Email обязательно.',
            'password' => 'Поле Пароль обязательно.',
        ]);

        $this->assertFalse(session()->hasOldInput('name'));
        $this->assertFalse(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserValidateIncorrectData(): void
    {
        $this->post(route('users.store'), [
            'name' => ' ! Test @',
            'email' => 'invalid-mail.ru',
            'password' => '!12345@',
            'password_confirmation' => '!12345@',
        ])->assertInvalid([
            'name' => 'Значение поля Имя имеет некорректный формат.',
            'email' => 'Значение поля Email должно быть действительным электронным адресом.',
            'password' => 'Значение поля Пароль имеет некорректный формат.',
        ]);

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserValidateWithExistingEmail(): void
    {
        $item = User::factory()->create();

        $this->post(route('users.store'), [
            'name' => 'Test',
            'email' => $item->email,
            'password' => '12345j',
            'password_confirmation' => '12345j',
        ])->assertInvalid([
            'email' => 'Такое значение поля Email уже существует.',
        ]);

        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }

    public function testUserValidateCorrectData(): void
    {
        $response = $this->post(route('users.store'), [
            'name' => 'Test Test',
            'email' => 'test@example.com',
            'password' => '12345j',
            'password_confirmation' => '12345j',
        ]);

        $user = User::get()->first();

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseHas(User::class, [
            'name' => 'Test Test',
            'email' => 'test@example.com',
        ]);
        $this->assertSame('Test Test', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertFalse($user->is_banned);
    }

}
