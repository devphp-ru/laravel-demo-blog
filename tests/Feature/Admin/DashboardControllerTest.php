<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class DashboardControllerTest extends TestCase
{
    use RouteTrait;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
    }

    public function testGetAResponseFromTheIndexPage(): void
    {
        $response = $this->get($this->routeAdminDashboardIndex());

        $response->assertStatus(200);
    }

    public function testGetViewDashboardIndex(): void
    {
        $response = $this->get($this->routeAdmindashboardIndex());
        $title = 'Панель управления';

        $response->assertSuccessful();
        $response->assertViewIs('admin.dashboards.index');
        $response->assertViewMissing($title);
    }

}
