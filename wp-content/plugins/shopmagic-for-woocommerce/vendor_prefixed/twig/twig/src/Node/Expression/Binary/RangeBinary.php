<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node\Expression\Binary;

use ShopMagicVendor\Twig\Compiler;
class RangeBinary extends \ShopMagicVendor\Twig\Node\Expression\Binary\AbstractBinary
{
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('range(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        return $compiler->raw('..');
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Binary\\RangeBinary', 'ShopMagicVendor\\Twig_Node_Expression_Binary_Range');
