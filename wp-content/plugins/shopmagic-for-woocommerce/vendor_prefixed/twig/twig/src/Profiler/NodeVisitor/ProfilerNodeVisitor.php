<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Profiler\NodeVisitor;

use ShopMagicVendor\Twig\Environment;
use ShopMagicVendor\Twig\Node\BlockNode;
use ShopMagicVendor\Twig\Node\BodyNode;
use ShopMagicVendor\Twig\Node\MacroNode;
use ShopMagicVendor\Twig\Node\ModuleNode;
use ShopMagicVendor\Twig\Node\Node;
use ShopMagicVendor\Twig\NodeVisitor\AbstractNodeVisitor;
use ShopMagicVendor\Twig\Profiler\Node\EnterProfileNode;
use ShopMagicVendor\Twig\Profiler\Node\LeaveProfileNode;
use ShopMagicVendor\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class ProfilerNodeVisitor extends \ShopMagicVendor\Twig\NodeVisitor\AbstractNodeVisitor
{
    private $extensionName;
    public function __construct($extensionName)
    {
        $this->extensionName = $extensionName;
    }
    protected function doEnterNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env)
    {
        return $node;
    }
    protected function doLeaveNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env)
    {
        if ($node instanceof \ShopMagicVendor\Twig\Node\ModuleNode) {
            $varName = $this->getVarName();
            $node->setNode('display_start', new \ShopMagicVendor\Twig\Node\Node([new \ShopMagicVendor\Twig\Profiler\Node\EnterProfileNode($this->extensionName, \ShopMagicVendor\Twig\Profiler\Profile::TEMPLATE, $node->getTemplateName(), $varName), $node->getNode('display_start')]));
            $node->setNode('display_end', new \ShopMagicVendor\Twig\Node\Node([new \ShopMagicVendor\Twig\Profiler\Node\LeaveProfileNode($varName), $node->getNode('display_end')]));
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\BlockNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new \ShopMagicVendor\Twig\Node\BodyNode([new \ShopMagicVendor\Twig\Profiler\Node\EnterProfileNode($this->extensionName, \ShopMagicVendor\Twig\Profiler\Profile::BLOCK, $node->getAttribute('name'), $varName), $node->getNode('body'), new \ShopMagicVendor\Twig\Profiler\Node\LeaveProfileNode($varName)]));
        } elseif ($node instanceof \ShopMagicVendor\Twig\Node\MacroNode) {
            $varName = $this->getVarName();
            $node->setNode('body', new \ShopMagicVendor\Twig\Node\BodyNode([new \ShopMagicVendor\Twig\Profiler\Node\EnterProfileNode($this->extensionName, \ShopMagicVendor\Twig\Profiler\Profile::MACRO, $node->getAttribute('name'), $varName), $node->getNode('body'), new \ShopMagicVendor\Twig\Profiler\Node\LeaveProfileNode($varName)]));
        }
        return $node;
    }
    private function getVarName()
    {
        return \sprintf('__internal_%s', \hash('sha256', $this->extensionName));
    }
    public function getPriority()
    {
        return 0;
    }
}
\class_alias('ShopMagicVendor\\Twig\\Profiler\\NodeVisitor\\ProfilerNodeVisitor', 'ShopMagicVendor\\Twig_Profiler_NodeVisitor_Profiler');
