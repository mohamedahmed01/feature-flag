<?php
namespace Mohamedahmed01\FeatureFlag\Console;

use Illuminate\Console\Command;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;

class ManageFeatureFlagsCommand extends Command
{
    protected $signature = 'feature-flag:manage {flag : The name of the feature flag} {--enable : Enable the feature flag} {--disable : Disable the feature flag}';

    protected $description = 'Enable or disable a feature flag';

    private $featureFlag;

    public function __construct(FeatureFlagInterface $featureFlag)
    {
        parent::__construct();

        $this->featureFlag = $featureFlag;
    }

    public function handle()
    {
        $flag = $this->argument('flag');

        if (!$this->featureFlag->exists($flag)) {
            $this->error("The feature flag {$flag} does not exist.");

            return;
        }
        $featureFlag = $this->featureFlag->where('name', $flag)->first();
        if ($this->option('enable')) {
            $featureFlag->setEnabled(true);
            $featureFlag->save();

            $this->line("The feature flag {$flag} has been enabled.");
        } elseif ($this->option('disable')) {
            $featureFlag->setEnabled(false);
            $featureFlag->save();

            $this->line("The feature flag {$flag} has been disabled.");
        } else {
            $status = $featureFlag->isEnabled($flag) ? 'enabled' : 'disabled';

            $this->line("The feature flag {$flag} is currently {$status}.");
        }
    }
}