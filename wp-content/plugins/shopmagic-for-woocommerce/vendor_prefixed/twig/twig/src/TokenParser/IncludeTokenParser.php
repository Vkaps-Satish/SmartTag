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
namespace ShopMagicVendor\Twig\TokenParser;

use ShopMagicVendor\Twig\Node\IncludeNode;
use ShopMagicVendor\Twig\Token;
/**
 * Includes a template.
 *
 *   {% include 'header.html' %}
 *     Body
 *   {% include 'footer.html' %}
 */
class IncludeTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        list($variables, $only, $ignoreMissing) = $this->parseArguments();
        return new \ShopMagicVendor\Twig\Node\IncludeNode($expr, $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }
    protected function parseArguments()
    {
        $stream = $this->parser->getStream();
        $ignoreMissing = \false;
        if ($stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'ignore')) {
            $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'missing');
            $ignoreMissing = \true;
        }
        $variables = null;
        if ($stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'with')) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
        }
        $only = \false;
        if ($stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'only')) {
            $only = \true;
        }
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        return [$variables, $only, $ignoreMissing];
    }
    public function getTag()
    {
        return 'include';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\IncludeTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Include');
