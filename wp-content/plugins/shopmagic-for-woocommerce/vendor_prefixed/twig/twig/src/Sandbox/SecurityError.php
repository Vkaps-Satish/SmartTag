<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Sandbox;

use ShopMagicVendor\Twig\Error\Error;
/**
 * Exception thrown when a security error occurs at runtime.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SecurityError extends \ShopMagicVendor\Twig\Error\Error
{
}
\class_alias('ShopMagicVendor\\Twig\\Sandbox\\SecurityError', 'ShopMagicVendor\\Twig_Sandbox_SecurityError');