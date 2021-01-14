<?php

namespace ShopMagicVendor\WPDesk\Composer\Codeception;

use ShopMagicVendor\Composer\Composer;
use ShopMagicVendor\Composer\IO\IOInterface;
use ShopMagicVendor\Composer\Plugin\Capable;
use ShopMagicVendor\Composer\Plugin\PluginInterface;
/**
 * Composer plugin.
 *
 * @package WPDesk\Composer\Codeception
 */
class Plugin implements \ShopMagicVendor\Composer\Plugin\PluginInterface, \ShopMagicVendor\Composer\Plugin\Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(\ShopMagicVendor\Composer\Composer $composer, \ShopMagicVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\ShopMagicVendor\Composer\Plugin\Capability\CommandProvider::class => \ShopMagicVendor\WPDesk\Composer\Codeception\CommandProvider::class];
    }
}
