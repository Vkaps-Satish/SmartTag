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
/**
 * Represents an if node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IfNode extends \ShopMagicVendor\Twig\Node\Node
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $tests, \ShopMagicVendor\Twig_NodeInterface $else = null, $lineno, $tag = null)
    {
        $nodes = ['tests' => $tests];
        if (null !== $else) {
            $nodes['else'] = $else;
        }
        parent::__construct($nodes, [], $lineno, $tag);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        for ($i = 0, $count = \count($this->getNode('tests')); $i < $count; $i += 2) {
            if ($i > 0) {
                $compiler->outdent()->write('} elseif (');
            } else {
                $compiler->write('if (');
            }
            $compiler->subcompile($this->getNode('tests')->getNode($i))->raw(") {\n")->indent()->subcompile($this->getNode('tests')->getNode($i + 1));
        }
        if ($this->hasNode('else')) {
            $compiler->outdent()->write("} else {\n")->indent()->subcompile($this->getNode('else'));
        }
        $compiler->outdent()->write("}\n");
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\IfNode', 'ShopMagicVendor\\Twig_Node_If');
