<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\TokenParser;

use ShopMagicVendor\Twig\Parser;
/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractTokenParser implements \ShopMagicVendor\Twig\TokenParser\TokenParserInterface
{
    /**
     * @var Parser
     */
    protected $parser;
    public function setParser(\ShopMagicVendor\Twig\Parser $parser)
    {
        $this->parser = $parser;
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\AbstractTokenParser', 'ShopMagicVendor\\Twig_TokenParser');
