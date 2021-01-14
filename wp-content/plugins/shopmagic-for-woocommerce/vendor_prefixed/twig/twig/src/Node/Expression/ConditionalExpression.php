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
namespace ShopMagicVendor\Twig\Node\Expression;

use ShopMagicVendor\Twig\Compiler;
class ConditionalExpression extends \ShopMagicVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\ShopMagicVendor\Twig\Node\Expression\AbstractExpression $expr1, \ShopMagicVendor\Twig\Node\Expression\AbstractExpression $expr2, \ShopMagicVendor\Twig\Node\Expression\AbstractExpression $expr3, $lineno)
    {
        parent::__construct(['expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3], [], $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('((')->subcompile($this->getNode('expr1'))->raw(') ? (')->subcompile($this->getNode('expr2'))->raw(') : (')->subcompile($this->getNode('expr3'))->raw('))');
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\ConditionalExpression', 'ShopMagicVendor\\Twig_Node_Expression_Conditional');
