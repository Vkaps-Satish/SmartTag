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
use ShopMagicVendor\Twig\Error\SyntaxError;
use ShopMagicVendor\Twig\Node\Expression\ArrayExpression;
use ShopMagicVendor\Twig\Node\Expression\BlockReferenceExpression;
use ShopMagicVendor\Twig\Node\Expression\ConstantExpression;
use ShopMagicVendor\Twig\Node\Expression\FunctionExpression;
use ShopMagicVendor\Twig\Node\Expression\GetAttrExpression;
use ShopMagicVendor\Twig\Node\Expression\NameExpression;
use ShopMagicVendor\Twig\Node\Expression\TestExpression;
/**
 * Checks if a variable is defined in the current context.
 *
 *    {# defined works with variable names and variable attributes #}
 *    {% if foo is defined %}
 *        {# ... #}
 *    {% endif %}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefinedTest extends \ShopMagicVendor\Twig\Node\Expression\TestExpression
{
    public function __construct(\ShopMagicVendor\Twig_NodeInterface $node, $name, \ShopMagicVendor\Twig_NodeInterface $arguments = null, $lineno)
    {
        if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\Expression\GetAttrExpression) {
            $node->setAttribute('is_defined_test', \true);
            $this->changeIgnoreStrictCheck($node);
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\Expression\BlockReferenceExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\Expression\FunctionExpression && 'constant' === $node->getAttribute('name')) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\Expression\ConstantExpression || $node instanceof \ShopMagicVendor\Twig\Node\Expression\ArrayExpression) {
            $node = new \ShopMagicVendor\Twig\Node\Expression\ConstantExpression(\true, $node->getTemplateLine());
        } else {
            throw new \ShopMagicVendor\Twig\Error\SyntaxError('The "defined" test only works with simple variables.', $lineno);
        }
        parent::__construct($node, $name, $arguments, $lineno);
    }
    protected function changeIgnoreStrictCheck(\ShopMagicVendor\Twig\Node\Expression\GetAttrExpression $node)
    {
        $node->setAttribute('ignore_strict_check', \true);
        if ($node->getNode('node') instanceof \ShopMagicVendor\Twig\Node\Expression\GetAttrExpression) {
            $this->changeIgnoreStrictCheck($node->getNode('node'));
        }
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\Expression\\Test\\DefinedTest', 'ShopMagicVendor\\Twig_Node_Expression_Test_Defined');
