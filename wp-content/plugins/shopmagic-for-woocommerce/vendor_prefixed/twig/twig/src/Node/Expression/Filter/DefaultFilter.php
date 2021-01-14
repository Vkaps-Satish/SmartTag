<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node\Expression\Filter;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\Node\Expression\ConditionalExpression;
use ShopMagicVendor\Twig\Node\Expression\ConstantExpression;
use ShopMagicVendor\Twig\Node\Expression\FilterExpression;
use ShopMagicVendor\Twig\Node\Expression\GetAttrExpression;
use ShopMagicVendor\Twig\Node\Expression\NameExpression;
use ShopMagicVendor\Twig\Node\Expression\Test\DefinedTest;
use ShopMagicVendor\Twig\Node\Node;
/**
 * Returns the value or the default value when it is undefined or empty.
 *
 *  {{ var.foo|default('foo item on var is not defined') }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefaultFilter extends \ShopMagicVendor\Twig\Node\Expression\FilterExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $node, \ShopMagicVendor\Twig\Node\Expression\ConstantExpression $filterName, \ShopMagicVendor\Twig_NodeInterface $arguments, $lineno, $tag = null)
    {
        $default = new \ShopMagicVendor\Twig\Node\Expression\FilterExpression($node, new \ShopMagicVendor\Twig\Node\Expression\ConstantExpression('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());
        if ('default' === $filterName->getAttribute('value') && ($node instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression || $node instanceof \ShopMagicVendor\Twig\Node\Expression\GetAttrExpression)) {
            $test = new \ShopMagicVendor\Twig\Node\Expression\Test\DefinedTest(clone $node, 'defined', new \ShopMagicVendor\Twig\Node\Node(), $node->getTemplateLine());
            $false = \count($arguments) ? $arguments->getNode(0) : new \ShopMagicVendor\Twig\Node\Expression\ConstantExpression('', $node->getTemplateLine());
            $node = new \ShopMagicVendor\Twig\Node\Expression\ConditionalExpression($test, $default, $false, $node->getTemplateLine());
        } else {
            $node = $default;
        }
        parent::__construct($node, $filterName, $arguments, $lineno, $tag);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Filter\\DefaultFilter', 'ShopMagicVendor\\Twig_Node_Expression_Filter_Default');
