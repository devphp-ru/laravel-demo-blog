<?php

declare(strict_types=1);

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

    public function test_get_response_from_the_index_page(): void
    {
        $response = $this->get($this->routeAdminDashboardIndex());

        $response->assertStatus(200);
    }

    public function test_get_view_dashboard_index(): void
    {
        $response = $this->get($this->routeAdminDashboardIndex());
        $title = 'Панель управления';

        $response->assertSuccessful();
        $response->assertViewIs('admin.dashboards.index');
        $response->assertViewMissing($title);
    }

}
