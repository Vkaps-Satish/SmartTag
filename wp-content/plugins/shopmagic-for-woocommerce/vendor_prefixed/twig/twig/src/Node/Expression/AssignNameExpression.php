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

use ShopMagicVendor\Twig\Compiler;
class AssignNameExpression extends \ShopMagicVendor\Twig\Node\Expression\NameExpression
{
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('$context[')->string($this->getAttribute('name'))->raw(']');
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\AssignNameExpression', 'ShopMagicVendor\\Twig_Node_Expression_AssignName');
