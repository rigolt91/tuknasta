<?php

namespace Tests\Feature\AdminPanel;

use App\Http\Livewire\AdminPanel\User\CreateComponent;
use App\Http\Livewire\AdminPanel\User\EditComponent;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleTableSeeder::class);
    }

    public function test_creating_a_user_assigns_the_selected_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('administrator');
        $editorRole = Role::where('name', 'editor')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(CreateComponent::class)
            ->set('name', 'New')
            ->set('last_name', 'Editor')
            ->set('email', 'new.editor@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('role', $editorRole->id)
            ->call('store');

        $created = User::where('email', 'new.editor@example.com')->firstOrFail();

        $this->assertTrue($created->hasRole('editor'));
    }

    public function test_editing_a_user_replaces_their_previous_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('administrator');

        $target = User::factory()->create();
        $target->assignRole('customer');
        $editorRole = Role::where('name', 'editor')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(EditComponent::class, ['user' => $target])
            ->set('role', $editorRole->id)
            ->call('update');

        $target->refresh();

        $this->assertTrue($target->hasRole('editor'));
        $this->assertFalse($target->hasRole('customer'));
        $this->assertCount(1, $target->roles);
    }
}
