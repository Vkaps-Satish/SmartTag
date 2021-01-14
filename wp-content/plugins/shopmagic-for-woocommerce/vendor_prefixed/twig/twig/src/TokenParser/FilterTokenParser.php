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

use ShopMagicVendor\Twig\Node\BlockNode;
use ShopMagicVendor\Twig\Node\Expression\BlockReferenceExpression;
use ShopMagicVendor\Twig\Node\Expression\ConstantExpression;
use ShopMagicVendor\Twig\Node\PrintNode;
use ShopMagicVendor\Twig\Token;
/**
 * Filters a section of a template by applying filters.
 *
 *   {% filter upper %}
 *      This text becomes uppercase
 *   {% endfilter %}
 *
 * @final
 */
class FilterTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $name = $this->parser->getVarName();
        $ref = new \ShopMagicVendor\Twig\Node\Expression\BlockReferenceExpression(new \ShopMagicVendor\Twig\Node\Expression\ConstantExpression($name, $token->getLine()), null, $token->getLine(), $this->getTag());
        $filter = $this->parser->getExpressionParser()->parseFilterExpressionRaw($ref, $this->getTag());
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $block = new \ShopMagicVendor\Twig\Node\BlockNode($name, $body, $token->getLine());
        $this->parser->setBlock($name, $block);
        return new \ShopMagicVendor\Twig\Node\PrintNode($filter, $token->getLine(), $this->getTag());
    }
    public function decideBlockEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endfilter');
    }
    public function getTag()
    {
        return 'filter';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\FilterTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Filter');
