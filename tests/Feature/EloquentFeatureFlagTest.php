<?php
namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Mohamedahmed01\FeatureFlag\Tests\TestCase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;
use Mohamedahmed01\FeatureFlag\Notifications\ExpiredFeatureFlagNotification;

class EloquentFeatureFlagTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateFeatureFlag()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);
        $featureFlag->save();

        $this->assertDatabaseHas('feature_flags', [
            'name' => 'test',
            'description' => 'Test feature flag',
        ]);

        $this->assertInstanceOf(FeatureFlagInterface::class, $featureFlag);
    }

    public function testSetEnabled()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
            'enabled' => false,
        ]);
        $featureFlag->save();

        $featureFlag->setEnabled(true);

        $this->assertTrue($featureFlag->isEnabled());
    }

    public function testSetAudience()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
            'audience' => ['users' => [1, 2, 3]],
        ]);
        $featureFlag->save();

        $featureFlag->setAudience(['users' => [4, 5, 6]]);

        $this->assertEquals(['users' => [4, 5, 6]], $featureFlag->getAudience());
    }

    public function testIsEnabledForUser()
    {
        $featureFlag = new EloquentFeatureFlag([
            'name' => 'test',
            'description' => 'Test feature flag',
            'percentage' => 50
        ]);

        $users = [];
        for ($i = 1; $i < 101; $i++) {
            $users[] = (object) ['id' => $i];
        }

        $enabledCount = 0;
        foreach ($users as $user) {
            if ($featureFlag->isEnabledForUser($user)) {
                $enabledCount++;
            }
        }

        $expectedEnabledCount = $featureFlag->percentage / 100 * count($users);
        $this->assertGreaterThanOrEqual($expectedEnabledCount - 5, $enabledCount);
        $this->assertLessThanOrEqual($expectedEnabledCount + 5, $enabledCount);
    }
    /** @test */
    public function itChecksIfFeatureFlagIsEnabled()
    {
        $flag = new EloquentFeatureFlag([
            'name' => 'test flag',
            'finish_date' => Carbon::now()->addDay(),
            'enabled' => true,
        ]);

        $this->assertTrue($flag->isEnabled());
    }

    /** @test */
    public function itThrowsExceptionIfFeatureFlagHasExpired()
    {
        $flag = new EloquentFeatureFlag([
            'name' => 'test flag',
            'finish_date' => Carbon::now()->subDay(),
            'enabled' => true,
        ]);

        $this->expectException(\Exception::class);
        $flag->isEnabled();
    }

    /** @test */
    public function itSendsNotificationIfFeatureFlagHasExpired()
    {
        Notification::fake();

        $flag = new EloquentFeatureFlag([
            'name' => 'test flag',
            'finish_date' => Carbon::now()->subDay(),
            'enabled' => true,
        ]);

        $flag->notifyIfExpired();

        Notification::assertSentTo(new AnonymousNotifiable(), ExpiredFeatureFlagNotification::class);
    }

    /** @test */
    public function itSendsNotificationIfFeatureFlagHasExpiredUsingConfig()
    {
        Notification::fake();

        $flag = new EloquentFeatureFlag([
            'name' => 'test flag',
            'finish_date' => Carbon::now()->subDay(),
            'enabled' => true,
        ]);
        config(['feature_flag.finish_date_action' => 'notification']);
        $flag->isEnabled();
        Notification::assertSentTo(new AnonymousNotifiable(), ExpiredFeatureFlagNotification::class);
    }

}