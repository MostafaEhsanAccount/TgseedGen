<?php

namespace Tests\Unit;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Exercises the BelongsToTenant trait in isolation against a disposable
 * table, since no real business model uses it yet (that starts in Phase 1
 * with Lead, etc.). This is the mechanism every tenant-scoped model will
 * rely on, so it is tested directly rather than only indirectly later.
 */
class BelongsToTenantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('scoped_widgets', function ($table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function test_creating_a_record_auto_fills_the_current_users_tenant_id(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $widget = ScopedWidget::create(['name' => 'Widget A']);

        $this->assertSame($tenant->id, $widget->tenant_id);
    }

    public function test_a_tenant_cannot_see_another_tenants_records(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();
        $userA = User::factory()->create(['tenant_id' => $tenantA->id]);
        $userB = User::factory()->create(['tenant_id' => $tenantB->id]);

        $this->actingAs($userA);
        ScopedWidget::create(['name' => 'Belongs to A']);

        $this->actingAs($userB);
        ScopedWidget::create(['name' => 'Belongs to B']);

        $this->actingAs($userA);
        $visible = ScopedWidget::all();

        $this->assertCount(1, $visible);
        $this->assertSame('Belongs to A', $visible->first()->name);
    }

    public function test_a_guest_query_is_not_tenant_scoped(): void
    {
        $tenantA = Tenant::factory()->create();
        $userA = User::factory()->create(['tenant_id' => $tenantA->id]);

        $this->actingAs($userA);
        ScopedWidget::create(['name' => 'Only widget']);

        auth()->logout();

        $this->assertCount(1, ScopedWidget::all());
    }
}

class ScopedWidget extends Model
{
    use BelongsToTenant;

    protected $table = 'scoped_widgets';

    protected $fillable = ['name', 'tenant_id'];
}
