<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Extension;

use ShopMagicVendor\Twig\Profiler\NodeVisitor\ProfilerNodeVisitor;
use ShopMagicVendor\Twig\Profiler\Profile;
class ProfilerExtension extends \ShopMagicVendor\Twig\Extension\AbstractExtension
{
    private $actives = [];
    public function __construct(\ShopMagicVendor\Twig\Profiler\Profile $profile)
    {
        $this->actives[] = $profile;
    }
    public function enter(\ShopMagicVendor\Twig\Profiler\Profile $profile)
    {
        $this->actives[0]->addProfile($profile);
        \array_unshift($this->actives, $profile);
    }
    public function leave(\ShopMagicVendor\Twig\Profiler\Profile $profile)
    {
        $profile->leave();
        \array_shift($this->actives);
        if (1 === \count($this->actives)) {
            $this->actives[0]->leave();
        }
    }
    public function getNodeVisitors()
    {
        return [new \ShopMagicVendor\Twig\Profiler\NodeVisitor\ProfilerNodeVisitor(\get_class($this))];
    }
    public function getName()
    {
        return 'profiler';
    }
}
\class_alias('ShopMagicVendor\\Twig\\Extension\\ProfilerExtension', 'ShopMagicVendor\\Twig_Extension_Profiler');
