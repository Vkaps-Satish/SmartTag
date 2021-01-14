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
use ShopMagicVendor\Twig\Node\Node;
/**
 * @internal
 */
final class InlinePrint extends \ShopMagicVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\ShopMagicVendor\Twig\Node\Node $node, $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }
    public function compile(\ShopMagicVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('print (')->subcompile($this->getNode('node'))->raw(')');
    }
}
