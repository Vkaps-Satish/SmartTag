<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Profiler\Dumper;

use ShopMagicVendor\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class TextDumper extends \ShopMagicVendor\Twig\Profiler\Dumper\BaseDumper
{
    protected function formatTemplate(\ShopMagicVendor\Twig\Profiler\Profile $profile, $prefix)
    {
        return \sprintf('%s└ %s', $prefix, $profile->getTemplate());
    }
    protected function formatNonTemplate(\ShopMagicVendor\Twig\Profiler\Profile $profile, $prefix)
    {
        return \sprintf('%s└ %s::%s(%s)', $prefix, $profile->getTemplate(), $profile->getType(), $profile->getName());
    }
    protected function formatTime(\ShopMagicVendor\Twig\Profiler\Profile $profile, $percent)
    {
        return \sprintf('%.2fms/%.0f%%', $profile->getDuration() * 1000, $percent);
    }
}
\class_alias('ShopMagicVendor\\Twig\\Profiler\\Dumper\\TextDumper', 'ShopMagicVendor\\Twig_Profiler_Dumper_Text');
