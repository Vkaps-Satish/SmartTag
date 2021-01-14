<?php

namespace ShopMagicVendor\WPDesk\Composer\Codeception;

use ShopMagicVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use ShopMagicVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \ShopMagicVendor\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new \ShopMagicVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests(), new \ShopMagicVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests()];
    }
}
