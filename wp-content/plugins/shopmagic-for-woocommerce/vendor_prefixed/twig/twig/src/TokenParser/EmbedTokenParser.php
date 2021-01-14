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

use ShopMagicVendor\Twig\Node\EmbedNode;
use ShopMagicVendor\Twig\Node\Expression\ConstantExpression;
use ShopMagicVendor\Twig\Node\Expression\NameExpression;
use ShopMagicVendor\Twig\Token;
/**
 * Embeds a template.
 *
 * @final
 */
class EmbedTokenParser extends \ShopMagicVendor\Twig\TokenParser\IncludeTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $stream = $this->parser->getStream();
        $parent = $this->parser->getExpressionParser()->parseExpression();
        list($variables, $only, $ignoreMissing) = $this->parseArguments();
        $parentToken = $fakeParentToken = new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::STRING_TYPE, '__parent__', $token->getLine());
        if ($parent instanceof \ShopMagicVendor\Twig\Node\Expression\ConstantExpression) {
            $parentToken = new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::STRING_TYPE, $parent->getAttribute('value'), $token->getLine());
        } elseif ($parent instanceof \ShopMagicVendor\Twig\Node\Expression\NameExpression) {
            $parentToken = new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::NAME_TYPE, $parent->getAttribute('name'), $token->getLine());
        }
        // inject a fake parent to make the parent() function work
        $stream->injectTokens([new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::BLOCK_START_TYPE, '', $token->getLine()), new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'extends', $token->getLine()), $parentToken, new \ShopMagicVendor\Twig\Token(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE, '', $token->getLine())]);
        $module = $this->parser->parse($stream, [$this, 'decideBlockEnd'], \true);
        // override the parent with the correct one
        if ($fakeParentToken === $parentToken) {
            $module->setNode('parent', $parent);
        }
        $this->parser->embedTemplate($module);
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        return new \ShopMagicVendor\Twig\Node\EmbedNode($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }
    public function decideBlockEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endembed');
    }
    public function getTag()
    {
        return 'embed';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\EmbedTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Embed');
