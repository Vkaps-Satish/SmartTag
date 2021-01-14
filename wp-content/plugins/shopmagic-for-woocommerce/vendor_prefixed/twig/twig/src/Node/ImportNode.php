<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Node;

use ShopMagicVendor\Twig\Compiler;
use ShopMagicVendor\Twig\Node\Expression\AbstractExpression;
use ShopMagicVendor\Twig\Node\Expression\NameExpression;
/**
 * Represents an import node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ImportNode extends \ShopMagicVendor\Twig\Node\Node
{
    public function __construct(\ShopMagicVendor\Twig\Node\Expression\AbstractExpression $expr, \ShopMagicVendor\Twig\Node\Expression\AbstractExpression $var, $lineno, $tag = null)
    {
        parent::__construct(['expr' => $expr, 'var' => $var], [], $lineno, $tag);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write('')->subcompile($this->getNode('var'))->raw(' = ');
        if ($this->getNode('expr') instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression && '_self' === $this->getNode('expr')->getAttribute('name')) {
            $compiler->raw('$this');
        } else {
            $compiler->raw('$this->loadTemplate(')->subcompile($this->getNode('expr'))->raw(', ')->repr($this->getTemplateName())->raw(', ')->repr($this->getTemplateLine())->raw(')->unwrap()');
        }
        $compiler->raw(";\n");
    }
}
\class_alias('ShopMagicVendor\\Twig\\Node\\ImportNode', 'ShopMagicVendor\\Twig_Node_Import');
