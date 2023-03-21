<?php

namespace Mohamedahmed01\FeatureFlag\Interfaces;

interface FeatureFlagInterface
{
    /**
     * Get the unique name of the feature flag.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the description of the feature flag.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Check if the feature flag is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Check if the feature flag is targeted to specific audience.
     *
     * @return bool
     */
    public function isTargeted(): bool;

    /**
     * Get the audience of the feature flag.
     *
     * @return array|null
     */
    public function getAudience(): ?array;

    /**
     * Set the status of the feature flag.
     *
     * @param bool $enabled
     *
     * @return void
     */
    public function setEnabled(bool $enabled): void;

    /**
     * Set the audience of the feature flag.
     *
     * @param array|null $audience
     *
     * @return void
     */
    public function setAudience(?array $audience): void;
}