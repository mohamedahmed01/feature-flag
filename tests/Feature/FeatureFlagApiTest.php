<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mohamedahmed01\FeatureFlag\Tests\TestCase;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;

class FeatureFlagApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_feature_flags()
    {
        factory(EloquentFeatureFlag::class,3)->create();
        $response = $this->getJson(route('feature-flags.index'));

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_feature_flag()
    {
        $data = [
            'name' => 'New Feature',
            'description' => 'Description of the new feature',
            'enabled' => true,
            'audience' => ['role' => 'admin'],
            'percentage' => 50,
            'finish_date' => now()->addDays(10)->toDateString(),
        ];

        $response = $this->postJson(route('feature-flags.store'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'New Feature']);
    }

    /** @test */
    public function it_can_show_a_feature_flag()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $response = $this->getJson(route('feature-flags.show', $featureFlag->id));

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $featureFlag->name]);
    }

    /** @test */
    public function it_can_update_a_feature_flag()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $data = ['name' => 'Updated Feature'];

        $response = $this->putJson(route('feature-flags.update', $featureFlag->id), $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Feature']);
    }

    /** @test */
    public function it_can_delete_a_feature_flag()
    {
        $featureFlag = factory(EloquentFeatureFlag::class)->create();

        $response = $this->deleteJson(route('feature-flags.destroy', $featureFlag->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('feature_flags', ['id' => $featureFlag->id]);
    }

    /** @test */
    public function it_can_generate_feature_flag_report()
    {
        factory(EloquentFeatureFlag::class,3)->create();

        $response = $this->getJson(route('feature-flags.report'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'total_flags',
                     'enabled_flags',
                     'disabled_flags',
                     'targeted_flags',
                     'untargeted_flags',
                 ]);
    }
}
