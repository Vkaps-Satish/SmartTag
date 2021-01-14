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
use ShopMagicVendor\Twig\Node\SetNode;
use ShopMagicVendor\Twig\Token;
/**
 * Defines a variable.
 *
 *  {% set foo = 'foo' %}
 *  {% set foo = [1, 2] %}
 *  {% set foo = {'foo': 'bar'} %}
 *  {% set foo = 'foo' ~ 'bar' %}
 *  {% set foo, bar = 'foo', 'bar' %}
 *  {% set foo %}Some content{% endset %}
 *
 * @final
 */
class SetTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $names = $this->parser->getExpressionParser()->parseAssignmentExpression();
        $capture = \false;
        if ($stream->nextIf(\ShopMagicVendor\Twig\Token::OPERATOR_TYPE, '=')) {
            $values = $this->parser->getExpressionParser()->parseMultitargetExpression();
            $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
            if (\count($names) !== \count($values)) {
                throw new \ShopMagicVendor\Twig\Error\SyntaxError('When using set, you must have the same number of variables and assignments.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
        } else {
            $capture = \true;
            if (\count($names) > 1) {
                throw new \ShopMagicVendor\Twig\Error\SyntaxError('When using set with a block, you cannot have a multi-target.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
            $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
            $values = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
            $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        }
        return new \ShopMagicVendor\Twig\Node\SetNode($capture, $names, $values, $lineno, $this->getTag());
    }
    public function decideBlockEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endset');
    }
    public function getTag()
    {
        return 'set';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\SetTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Set');
