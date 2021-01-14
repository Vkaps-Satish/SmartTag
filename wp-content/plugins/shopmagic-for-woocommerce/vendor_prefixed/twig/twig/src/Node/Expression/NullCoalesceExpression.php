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
use ShopMagicVendor\Twig\Node\Expression\Binary\AndBinary;
use ShopMagicVendor\Twig\Node\Expression\Test\DefinedTest;
use ShopMagicVendor\Twig\Node\Expression\Test\NullTest;
use ShopMagicVendor\Twig\Node\Expression\Unary\NotUnary;
use ShopMagicVendor\Twig\Node\Node;
class NullCoalesceExpression extends \ShopMagicVendor\Twig\Node\Expression\ConditionalExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $left, \ShopMagicVendor\Twig_NodeInterface $right, $lineno)
    {
        $test = new \ShopMagicVendor\Twig\Node\Expression\Test\DefinedTest(clone $left, 'defined', new \ShopMagicVendor\Twig\Node\Node(), $left->getTemplateLine());
        // for "block()", we don't need the null test as the return value is always a string
        if (!$left instanceof \ShopMagicVendor\Twig\Node\Expression\BlockReferenceExpression) {
            $test = new \ShopMagicVendor\Twig\Node\Expression\Binary\AndBinary($test, new \ShopMagicVendor\Twig\Node\Expression\Unary\NotUnary(new \ShopMagicVendor\Twig\Node\Expression\Test\NullTest($left, 'null', new \ShopMagicVendor\Twig\Node\Node(), $left->getTemplateLine()), $left->getTemplateLine()), $left->getTemplateLine());
        }
        parent::__construct($test, $left, $right, $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        /*
         * This optimizes only one case. PHP 7 also supports more complex expressions
         * that can return null. So, for instance, if log is defined, log("foo") ?? "..." works,
         * but log($a["foo"]) ?? "..." does not if $a["foo"] is not defined. More advanced
         * cases might be implemented as an optimizer node visitor, but has not been done
         * as benefits are probably not worth the added complexity.
         */
        if (\PHP_VERSION_ID >= 70000 && $this->getNode('expr2') instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression) {
            $this->getNode('expr2')->setAttribute('always_defined', \true);
            $compiler->raw('((')->subcompile($this->getNode('expr2'))->raw(') ?? (')->subcompile($this->getNode('expr3'))->raw('))');
        } else {
            parent::compile($compiler);
        }
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\NullCoalesceExpression', 'ShopMagicVendor\\Twig_Node_Expression_NullCoalesce');
