<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Cache;

/**
 * Implements a no-cache strategy.
 *
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class NullCache implements \ShopMagicVendor\Twig\Cache\CacheInterface
{
    public function generateKey($name, $className)
    {
        return '';
    }
    public function write($key, $content)
    {
    }
    public function load($key)
    {
    }
    public function getTimestamp($key)
    {
        return 0;
    }
}
\class_alias('ShopMagicVendor\\Twig\\Cache\\NullCache', 'ShopMagicVendor\\Twig_Cache_Null');
