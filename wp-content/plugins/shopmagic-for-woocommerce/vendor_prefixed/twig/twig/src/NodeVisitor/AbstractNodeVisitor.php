<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\NodeVisitor;

use ShopMagicVendor\Twig\Environment;
use ShopMagicVendor\Twig\Node\Node;
/**
 * Used to make node visitors compatible with Twig 1.x and 2.x.
 *
 * To be removed in Twig 3.1.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractNodeVisitor implements \ShopMagicVendor\Twig\NodeVisitor\NodeVisitorInterface
{
    public final function enterNode(\ShopMagicVendor\Twig_NodeInterface $node, \ShopMagicVendor\Twig\Environment $env)
    {
        if (!$node instanceof \ShopMagicVendor\Twig\Node\Node) {
            throw new \LogicException(\sprintf('%s only supports \\Twig\\Node\\Node instances.', __CLASS__));
        }
        return $this->doEnterNode($node, $env);
    }
    public final function leaveNode(\ShopMagicVendor\Twig_NodeInterface $node, \ShopMagicVendor\Twig\Environment $env)
    {
        if (!$node instanceof \ShopMagicVendor\Twig\Node\Node) {
            throw new \LogicException(\sprintf('%s only supports \\Twig\\Node\\Node instances.', __CLASS__));
        }
        return $this->doLeaveNode($node, $env);
    }
    /**
     * Called before child nodes are visited.
     *
     * @return Node The modified node
     */
    protected abstract function doEnterNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env);
    /**
     * Called after child nodes are visited.
     *
     * @return Node|false|null The modified node or null if the node must be removed
     */
    protected abstract function doLeaveNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env);
}
\class_alias('ShopMagicVendor\\Twig\\NodeVisitor\\AbstractNodeVisitor', 'ShopMagicVendor\\Twig_BaseNodeVisitor');
