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
use ShopMagicVendor\Twig\Node\CheckSecurityNode;
use ShopMagicVendor\Twig\Node\CheckToStringNode;
use ShopMagicVendor\Twig\Node\Expression\Binary\ConcatBinary;
use ShopMagicVendor\Twig\Node\Expression\Binary\RangeBinary;
use ShopMagicVendor\Twig\Node\Expression\FilterExpression;
use ShopMagicVendor\Twig\Node\Expression\FunctionExpression;
use ShopMagicVendor\Twig\Node\Expression\GetAttrExpression;
use ShopMagicVendor\Twig\Node\Expression\NameExpression;
use ShopMagicVendor\Twig\Node\ModuleNode;
use ShopMagicVendor\Twig\Node\Node;
use ShopMagicVendor\Twig\Node\PrintNode;
use ShopMagicVendor\Twig\Node\SetNode;
/**
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SandboxNodeVisitor extends \ShopMagicVendor\Twig\NodeVisitor\AbstractNodeVisitor
{
    protected $inAModule = \false;
    protected $tags;
    protected $filters;
    protected $functions;
    private $needsToStringWrap = \false;
    protected function doEnterNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env)
    {
        if ($node instanceof \ShopMagicVendor\Twig\Node\ModuleNode) {
            $this->inAModule = \true;
            $this->tags = [];
            $this->filters = [];
            $this->functions = [];
            return $node;
        } elseif ($this->inAModule) {
            // look for tags
            if ($node->getNodeTag() && !isset($this->tags[$node->getNodeTag()])) {
                $this->tags[$node->getNodeTag()] = $node;
            }
            // look for filters
            if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\FilterExpression && !isset($this->filters[$node->getNode('filter')->getAttribute('value')])) {
                $this->filters[$node->getNode('filter')->getAttribute('value')] = $node;
            }
            // look for functions
            if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\FunctionExpression && !isset($this->functions[$node->getAttribute('name')])) {
                $this->functions[$node->getAttribute('name')] = $node;
            }
            // the .. operator is equivalent to the range() function
            if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\Binary\RangeBinary && !isset($this->functions['range'])) {
                $this->functions['range'] = $node;
            }
            if ($node instanceof \ShopMagicVendor\Twig\Node\PrintNode) {
                $this->needsToStringWrap = \true;
                $this->wrapNode($node, 'expr');
            }
            if ($node instanceof \ShopMagicVendor\Twig\Node\SetNode && !$node->getAttribute('capture')) {
                $this->needsToStringWrap = \true;
            }
            // wrap outer nodes that can implicitly call __toString()
            if ($this->needsToStringWrap) {
                if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\Binary\ConcatBinary) {
                    $this->wrapNode($node, 'left');
                    $this->wrapNode($node, 'right');
                }
                if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\FilterExpression) {
                    $this->wrapNode($node, 'node');
                    $this->wrapArrayNode($node, 'arguments');
                }
                if ($node instanceof \ShopMagicVendor\Twig\Node\Expression\FunctionExpression) {
                    $this->wrapArrayNode($node, 'arguments');
                }
            }
        }
        return $node;
    }
    protected function doLeaveNode(\ShopMagicVendor\Twig\Node\Node $node, \ShopMagicVendor\Twig\Environment $env)
    {
        if ($node instanceof \ShopMagicVendor\Twig\Node\ModuleNode) {
            $this->inAModule = \false;
            $node->getNode('constructor_end')->setNode('_security_check', new \ShopMagicVendor\Twig\Node\Node([new \ShopMagicVendor\Twig\Node\CheckSecurityNode($this->filters, $this->tags, $this->functions), $node->getNode('display_start')]));
        } elseif ($this->inAModule) {
            if ($node instanceof \ShopMagicVendor\Twig\Node\PrintNode || $node instanceof \ShopMagicVendor\Twig\Node\SetNode) {
                $this->needsToStringWrap = \false;
            }
        }
        return $node;
    }
    private function wrapNode(\ShopMagicVendor\Twig\Node\Node $node, $name)
    {
        $expr = $node->getNode($name);
        if ($expr instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression || $expr instanceof \ShopMagicVendor\Twig\Node\Expression\GetAttrExpression) {
            $node->setNode($name, new \ShopMagicVendor\Twig\Node\CheckToStringNode($expr));
        }
    }
    private function wrapArrayNode(\ShopMagicVendor\Twig\Node\Node $node, $name)
    {
        $args = $node->getNode($name);
        foreach ($args as $name => $_) {
            $this->wrapNode($args, $name);
        }
    }
    public function getPriority()
    {
        return 0;
    }
}
\class_alias('ShopMagicVendor\\Twig\\NodeVisitor\\SandboxNodeVisitor', 'ShopMagicVendor\\Twig_NodeVisitor_Sandbox');
