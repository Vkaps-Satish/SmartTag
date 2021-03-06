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
class HtmlDumper extends \ShopMagicVendor\Twig\Profiler\Dumper\BaseDumper
{
    private static $colors = ['block' => '#dfd', 'macro' => '#ddf', 'template' => '#ffd', 'big' => '#d44'];
    public function dump(\ShopMagicVendor\Twig\Profiler\Profile $profile)
    {
        return '<pre>' . parent::dump($profile) . '</pre>';
    }
    protected function formatTemplate(\ShopMagicVendor\Twig\Profiler\Profile $profile, $prefix)
    {
        return \sprintf('%s└ <span style="background-color: %s">%s</span>', $prefix, self::$colors['template'], $profile->getTemplate());
    }
    protected function formatNonTemplate(\ShopMagicVendor\Twig\Profiler\Profile $profile, $prefix)
    {
        return \sprintf('%s└ %s::%s(<span style="background-color: %s">%s</span>)', $prefix, $profile->getTemplate(), $profile->getType(), isset(self::$colors[$profile->getType()]) ? self::$colors[$profile->getType()] : 'auto', $profile->getName());
    }
    protected function formatTime(\ShopMagicVendor\Twig\Profiler\Profile $profile, $percent)
    {
        return \sprintf('<span style="color: %s">%.2fms/%.0f%%</span>', $percent > 20 ? self::$colors['big'] : 'auto', $profile->getDuration() * 1000, $percent);
    }
}
\class_alias('ShopMagicVendor\\Twig\\Profiler\\Dumper\\HtmlDumper', 'ShopMagicVendor\\Twig_Profiler_Dumper_Html');
