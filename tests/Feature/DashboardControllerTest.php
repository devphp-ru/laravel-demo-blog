<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Traits\RouteTrait;

class DashboardControllerTest extends TestCase
{
    use RouteTrait;
    use WithoutMiddleware;

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
