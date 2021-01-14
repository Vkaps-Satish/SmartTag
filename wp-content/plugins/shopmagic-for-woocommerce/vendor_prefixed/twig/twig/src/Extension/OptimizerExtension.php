<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Extension;

use ShopMagicVendor\Twig\NodeVisitor\OptimizerNodeVisitor;
/**
 * @final
 */
class OptimizerExtension extends \ShopMagicVendor\Twig\Extension\AbstractExtension
{
    protected $optimizers;
    public function __construct($optimizers = -1)
    {
        $this->optimizers = $optimizers;
    }
    public function getNodeVisitors()
    {
        return [new \ShopMagicVendor\Twig\NodeVisitor\OptimizerNodeVisitor($this->optimizers)];
    }
    public function getName()
    {
        return 'optimizer';
    }
}
\class_alias('ShopMagicVendor\\Twig\\Extension\\OptimizerExtension', 'ShopMagicVendor\\Twig_Extension_Optimizer');
