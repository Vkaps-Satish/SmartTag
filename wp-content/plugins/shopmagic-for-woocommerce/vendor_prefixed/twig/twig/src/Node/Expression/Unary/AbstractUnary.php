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
use ShopMagicVendor\Twig\Node\Expression\AbstractExpression;
abstract class AbstractUnary extends \ShopMagicVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $node, $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw(' ');
        $this->operator($compiler);
        $compiler->subcompile($this->getNode('node'));
    }
    public abstract function operator(\ShopMagicVendor\Twig\Compiler $compiler);
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Unary\\AbstractUnary', 'ShopMagicVendor\\Twig_Node_Expression_Unary');
