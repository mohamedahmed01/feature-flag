<?php

namespace Mohamedahmed01\FeatureFlag;

use Illuminate\Support\Facades\Facade;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;

/**
 * @see \Mohamedahmed01\FeatureFlag\Skeleton\SkeletonClass
 */
class FeatureFlagFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FeatureFlagInterface::class;
    }
}