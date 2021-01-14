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
namespace ShopMagicVendor\Twig\Node;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\Node\Expression\AbstractExpression;
/**
 * Represents a node that outputs an expression.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PrintNode extends \ShopMagicVendor\Twig\Node\Node implements \ShopMagicVendor\Twig\Node\NodeOutputInterface
{
    public function __construct(\ShopMagicVendor\Twig\Node\Expression\AbstractExpression $expr, $lineno, $tag = null)
    {
        parent::__construct(['expr' => $expr], [], $lineno, $tag);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write('echo ')->subcompile($this->getNode('expr'))->raw(";\n");
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\PrintNode', 'ShopMagicVendor\\Twig_Node_Print');
