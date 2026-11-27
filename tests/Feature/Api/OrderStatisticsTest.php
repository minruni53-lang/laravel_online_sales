<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_statistics(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($admin, ['admin']);

        $response = $this->getJson('/api/v1/admin/order-statistics');

        $response->assertStatus(200);
    }

    public function test_customer_cannot_view_statistics(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        Sanctum::actingAs($customer, ['customer']);

        $response = $this->getJson('/api/v1/admin/order-statistics');

        $response->assertStatus(403);
    }
}