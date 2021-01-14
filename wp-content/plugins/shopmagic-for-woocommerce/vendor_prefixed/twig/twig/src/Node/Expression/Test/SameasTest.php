<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node\Expression\Test;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\Node\Expression\TestExpression;
/**
 * Checks if a variable is the same as another one (=== in PHP).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SameasTest extends \ShopMagicVendor\Twig\Node\Expression\TestExpression
{
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('node'))->raw(' === ')->subcompile($this->getNode('arguments')->getNode(0))->raw(')');
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Test\\SameasTest', 'ShopMagicVendor\\Twig_Node_Expression_Test_Sameas');
