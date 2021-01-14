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
namespace ShopMagicVendor\Twig\Node\Expression\Binary;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\Node\Expression\AbstractExpression;
abstract class AbstractBinary extends \ShopMagicVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $left, \ShopMagicVendor\Twig_NodeInterface $right, $lineno)
    {
        parent::__construct(['left' => $left, 'right' => $right], [], $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('left'))->raw(' ');
        $this->operator($compiler);
        $compiler->raw(' ')->subcompile($this->getNode('right'))->raw(')');
    }
    public abstract function operator(\ShopMagicVendor\Twig\Compiler $compiler);
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Binary\\AbstractBinary', 'ShopMagicVendor\\Twig_Node_Expression_Binary');
