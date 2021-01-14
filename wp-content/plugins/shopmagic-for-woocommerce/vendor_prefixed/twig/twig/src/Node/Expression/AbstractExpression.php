<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node\Expression;

use ShopMagicVendor\Twig\Node\Node;
/**
 * Abstract class for all nodes that represents an expression.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractExpression extends \ShopMagicVendor\Twig\Node\Node
{
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\AbstractExpression', 'ShopMagicVendor\\Twig_Node_Expression');
