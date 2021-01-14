<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node\Expression;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\TwigTest;
class TestExpression extends \ShopMagicVendor\Twig\Node\Expression\CallExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $node, $name, \ShopMagicVendor\Twig_NodeInterface $arguments = null, $lineno)
    {
        $nodes = ['node' => $node];
        if (null !== $arguments) {
            $nodes['arguments'] = $arguments;
        }
        parent::__construct($nodes, ['name' => $name], $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $test = $compiler->getEnvironment()->getTest($name);
        $this->setAttribute('name', $name);
        $this->setAttribute('type', 'test');
        $this->setAttribute('thing', $test);
        if ($test instanceof \ShopMagicVendor\Twig\TwigTest) {
            $this->setAttribute('arguments', $test->getArguments());
        }
        if ($test instanceof \ShopMagicVendor\Twig_TestCallableInterface || $test instanceof \ShopMagicVendor\Twig\TwigTest) {
            $this->setAttribute('callable', $test->getCallable());
        }
        if ($test instanceof \ShopMagicVendor\Twig\TwigTest) {
            $this->setAttribute('is_variadic', $test->isVariadic());
        }
        $this->compileCallable($compiler);
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\TestExpression', 'ShopMagicVendor\\Twig_Node_Expression_Test');
