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

use ShopMagicVendor\Twig\Error\SyntaxError;
use ShopMagicVendor\Twig\Node\BlockNode;
use ShopMagicVendor\Twig\Node\BlockReferenceNode;
use ShopMagicVendor\Twig\Node\Node;
use ShopMagicVendor\Twig\Node\PrintNode;
use ShopMagicVendor\Twig\Token;
/**
 * Marks a section of a template as being reusable.
 *
 *  {% block head %}
 *    <link rel="stylesheet" href="style.css" />
 *    <title>{% block title %}{% endblock %} - My Webpage</title>
 *  {% endblock %}
 *
 * @final
 */
class BlockTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
        if ($this->parser->hasBlock($name)) {
            throw new \ShopMagicVendor\Twig\Error\SyntaxError(\sprintf("The block '%s' has already been defined line %d.", $name, $this->parser->getBlock($name)->getTemplateLine()), $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }
        $this->parser->setBlock($name, $block = new \ShopMagicVendor\Twig\Node\BlockNode($name, new \ShopMagicVendor\Twig\Node\Node([]), $lineno));
        $this->parser->pushLocalScope();
        $this->parser->pushBlockStack($name);
        if ($stream->nextIf(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE)) {
            $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
            if ($token = $stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE)) {
                $value = $token->getValue();
                if ($value != $name) {
                    throw new \ShopMagicVendor\Twig\Error\SyntaxError(\sprintf('Expected endblock for block "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
                }
            }
        } else {
            $body = new \ShopMagicVendor\Twig\Node\Node([new \ShopMagicVendor\Twig\Node\PrintNode($this->parser->getExpressionParser()->parseExpression(), $lineno)]);
        }
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $block->setNode('body', $body);
        $this->parser->popBlockStack();
        $this->parser->popLocalScope();
        return new \ShopMagicVendor\Twig\Node\BlockReferenceNode($name, $lineno, $this->getTag());
    }
    public function decideBlockEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endblock');
    }
    public function getTag()
    {
        return 'block';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\BlockTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Block');
