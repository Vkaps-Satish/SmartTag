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

use ShopMagicVendor\Twig\Node\WithNode;
use ShopMagicVendor\Twig\Token;
/**
 * Creates a nested scope.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class WithTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $stream = $this->parser->getStream();
        $variables = null;
        $only = \false;
        if (!$stream->test(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE)) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
            $only = $stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'only');
        }
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideWithEnd'], \true);
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        return new \ShopMagicVendor\Twig\Node\WithNode($body, $variables, $only, $token->getLine(), $this->getTag());
    }
    public function decideWithEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endwith');
    }
    public function getTag()
    {
        return 'with';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\WithTokenParser', 'ShopMagicVendor\\Twig_TokenParser_With');
