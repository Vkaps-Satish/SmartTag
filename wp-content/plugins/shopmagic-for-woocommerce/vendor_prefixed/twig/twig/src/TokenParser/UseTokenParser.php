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

use ShopMagicVendor\Twig\Error\SyntaxError;
use ShopMagicVendor\Twig\Node\Expression\ConstantExpression;
use ShopMagicVendor\Twig\Node\Node;
use ShopMagicVendor\Twig\Token;
/**
 * Imports blocks defined in another template into the current template.
 *
 *    {% extends "base.html" %}
 *
 *    {% use "blocks.html" %}
 *
 *    {% block title %}{% endblock %}
 *    {% block content %}{% endblock %}
 *
 * @see https://twig.symfony.com/doc/templates.html#horizontal-reuse for details.
 *
 * @final
 */
class UseTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $template = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();
        if (!$template instanceof \ShopMagicVendor\Twig\Node\Expression\ConstantExpression) {
            throw new \ShopMagicVendor\Twig\Error\SyntaxError('The template references in a "use" statement must be a string.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }
        $targets = [];
        if ($stream->nextIf('with')) {
            do {
                $name = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
                $alias = $name;
                if ($stream->nextIf('as')) {
                    $alias = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
                }
                $targets[$name] = new \ShopMagicVendor\Twig\Node\Expression\ConstantExpression($alias, -1);
                if (!$stream->nextIf(\ShopMagicVendor\Twig\Token::PUNCTUATION_TYPE, ',')) {
                    break;
                }
            } while (\true);
        }
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->addTrait(new \ShopMagicVendor\Twig\Node\Node(['template' => $template, 'targets' => new \ShopMagicVendor\Twig\Node\Node($targets)]));
        return new \ShopMagicVendor\Twig\Node\Node();
    }
    public function getTag()
    {
        return 'use';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\UseTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Use');
