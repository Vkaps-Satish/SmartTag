<?php

namespace ShopMagicVendor\WPDesk\Composer\Codeception\Commands;

use ShopMagicVendor\Composer\Command\BaseCommand as CodeceptionBaseCommand;
use ShopMagicVendor\Symfony\Component\Console\Output\OutputInterface;
/**
 * Base for commands - declares common methods.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
abstract class BaseCommand extends \ShopMagicVendor\Composer\Command\BaseCommand
{
    /**
     * @param string $command
     * @param OutputInterface $output
     */
    protected function execAndOutput($command, \ShopMagicVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        \passthru($command);
    }
}
