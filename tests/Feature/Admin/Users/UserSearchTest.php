<?php

namespace Tests\Feature\Admin\Users;

use App\Models\AdminUser;
use App\Models\User;
use App\Services\Users\UserRepository;
use App\Services\Users\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserSearchTest extends TestCase
{
    use RefreshDatabase;
    private UserService $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->userService = new UserService(new UserRepository());
    }

    public function testSearchUsersToNameAndEmail(): void
    {
        $item = $this->userFactory();
        $perPage = 10;
        $request = new Request(['q' => 'TesT']);

        $users = $this->userService->getAllAdminsWithPagination($request, $perPage);
        $user = $users->first();

        $this->assertCount(1, $users);
        $this->assertSame($item->name, $user->name);
        $this->assertSame($item->email, $user->email);
    }

    public function testSearchWithoutData(): void
    {
        $this->userFactory();
        $perPage = 10;
        $request = new Request(['q' => '']);

        $users = $this->userService->getAllAdminsWithPagination($request, $perPage);

        $this->assertFalse($users->isEmpty());
    }

    private function userFactory(): User
    {
        User::factory(20)->create();

        return User::factory()->create([
            'name' => 'Test tester',
            'email' => 'test@example.com',
        ]);
    }

}
