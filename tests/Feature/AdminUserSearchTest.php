<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Services\AdminUsers\AdminUserRepository;
use App\Services\AdminUsers\AdminUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class AdminUserSearchTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;
    use WithoutMiddleware;

    private AdminUserService $adminUserService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create());
        $this->adminUserService = new AdminUserService(new AdminUserRepository());
    }

    public function testSearchUserToName(): void
    {
        $this->createAdminUsers(15);
        $item = AdminUser::factory()->create([
            'username' => 'Test',
        ]);

        $perPage = 10;
        $request = new Request(['q' => 'TesT']);

        $users = $this->adminUserService->getAllAdminsWithPagination($request, $perPage);
        $user = $users->first();

        $this->assertCount(1, $users);
        $this->assertSame($item->username, $user->username);
        $this->assertSame($item->email, $user->email);
    }

    public function testSearchUserToEmail(): void
    {
        $this->createAdminUsers(15);
        $item = AdminUser::factory()->create([
            'username' => 'Test',
            'email' => 'TesT@example.com',
        ]);
        $perPage = 10;
        $request = new Request(['q' => 'Test@example.com']);

        $users = $this->adminUserService->getAllAdminsWithPagination($request, $perPage);
        $user = $users->first();

        $this->assertCount(1, $users);
        $this->assertSame($item->username, $user->username);
        $this->assertSame($item->email, $user->email);
    }

    public function testSearchUserToNameAndEmail(): void
    {
        $this->createAdminUsers(15);
        $item = AdminUser::factory()->create([
            'username' => 'Test',
            'email' => 'TesT@example.com',
        ]);
        $perPage = 10;
        $request = new Request(['q' => 'TEST']);

        $users = $this->adminUserService->getAllAdminsWithPagination($request, $perPage);
        $user = $users->first();

        $this->assertCount(1, $users);
        $this->assertSame($item->username, $user->username);
        $this->assertSame($item->email, $user->email);
    }

    private function createAdminUsers(int $count): void
    {
        AdminUser::factory($count)->create();
    }

}
