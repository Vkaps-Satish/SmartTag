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
namespace ShopMagicVendor\Twig\Node\Expression\Unary;

use ShopMagicVendor\Twig\Compiler;
class NegUnary extends \ShopMagicVendor\Twig\Node\Expression\Unary\AbstractUnary
{
    public function operator(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('-');
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Unary\\NegUnary', 'ShopMagicVendor\\Twig_Node_Expression_Unary_Neg');
