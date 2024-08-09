<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mohamedahmed01\FeatureFlag\Tests\TestCase;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;

class FeatureFlagWebTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_feature_flags_list()
    {
        factory(EloquentFeatureFlag::class,3)->create();

        $response = $this->get(route('feature-flags-web.index'));
        $response->assertStatus(200)
                 ->assertViewIs('feature-flag::feature-flags.index')
                 ->assertViewHas('featureFlags');
    }

    /** @test */
    public function it_can_display_create_feature_flag_form()
    {
        $response = $this->get(route('feature-flags-web.create'));

        $response->assertStatus(200)
                 ->assertViewIs('feature-flag::feature-flags.create');
    }

    /** @test */
    public function it_can_store_a_new_feature_flag()
    {
        $data = [
            'name' => 'New Feature',
            'description' => 'Description of the new feature',
            'enabled' => true,
            'audience' => ['role' => 'admin'],
            'percentage' => 50,
            'finish_date' => now()->addDays(10)->toDateString(),
        ];

        $response = $this->post(route('feature-flags-web.store'), $data);

        $response->assertStatus(302)
                 ->assertRedirect(route('feature-flags-web.index'));

        $this->assertDatabaseHas('feature_flags', ['name' => 'New Feature']);
    }

    /** @test */
    public function it_can_display_a_feature_flag()
    {
        $featureFlag =  factory(EloquentFeatureFlag::class)->create();

        $response = $this->get(route('feature-flags-web.show', $featureFlag->id));

        $response->assertStatus(200)
                 ->assertViewIs('feature-flag::feature-flags.show')
                 ->assertViewHas('featureFlag', $featureFlag);
    }

    /** @test */
    public function it_can_display_edit_feature_flag_form()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $response = $this->get(route('feature-flags-web.edit', $featureFlag->id));
        $response->assertStatus(200)
                 ->assertViewIs('feature-flag::feature-flags.edit')
                 ->assertViewHas('featureFlag', $featureFlag);
    }

    /** @test */
    public function it_can_update_a_feature_flag()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $data = ['name' => 'Updated Feature'];

        $response = $this->put(route('feature-flags-web.update', $featureFlag->id), $data);

        $response->assertStatus(302)
                 ->assertRedirect(route('feature-flags-web.index'));

        $this->assertDatabaseHas('feature_flags', ['name' => 'Updated Feature']);
    }

    /** @test */
    public function it_can_delete_a_feature_flag()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $response = $this->delete(route('feature-flags-web.destroy', $featureFlag->id));

        $response->assertStatus(302)
                 ->assertRedirect(route('feature-flags-web.index'));

        $this->assertDatabaseMissing('feature_flags', ['id' => $featureFlag->id]);
    }

    /** @test */
    public function it_can_generate_feature_flag_report()
    {
        factory(EloquentFeatureFlag::class,3)->create();

        $response = $this->get(route('feature-flags-web.report'));
        $response->assertStatus(200)
                 ->assertViewIs('feature-flag::feature-flags.report')
                 ->assertViewHas('statistics');
    }
}
