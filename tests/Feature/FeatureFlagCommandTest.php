<?php
namespace Tests\Feature;

use Mohamedahmed01\FeatureFlag\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;

class FeatureFlagCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckingFlagStatus()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);
        $featureFlag->setEnabled(true);
        $featureFlag->save();
        $this->artisan('feature-flag:manage test')
            ->expectsOutput('The feature flag test is currently enabled.');
    }

    public function testEnablingFlagStatus()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);
        $featureFlag->save();
        $this->artisan('feature-flag:manage test --enable')
            ->expectsOutput('The feature flag test has been enabled.');
    }
    public function testDisablingFlagStatus()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);
        $featureFlag->save();
        $this->artisan('feature-flag:manage test --disable')
            ->expectsOutput('The feature flag test has been disabled.');
    }
}