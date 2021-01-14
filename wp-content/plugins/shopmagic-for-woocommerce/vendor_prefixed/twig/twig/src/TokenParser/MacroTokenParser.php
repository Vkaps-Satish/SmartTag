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
use ShopMagicVendor\Twig\Node\BodyNode;
use ShopMagicVendor\Twig\Node\MacroNode;
use ShopMagicVendor\Twig\Node\Node;
use ShopMagicVendor\Twig\Token;
/**
 * Defines a macro.
 *
 *   {% macro input(name, value, type, size) %}
 *      <input type="{{ type|default('text') }}" name="{{ name }}" value="{{ value|e }}" size="{{ size|default(20) }}" />
 *   {% endmacro %}
 *
 * @final
 */
class MacroTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
        $arguments = $this->parser->getExpressionParser()->parseArguments(\true, \true);
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->pushLocalScope();
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        if ($token = $stream->nextIf(\ShopMagicVendor\Twig\Token::NAME_TYPE)) {
            $value = $token->getValue();
            if ($value != $name) {
                throw new \ShopMagicVendor\Twig\Error\SyntaxError(\sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
        }
        $this->parser->popLocalScope();
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->setMacro($name, new \ShopMagicVendor\Twig\Node\MacroNode($name, new \ShopMagicVendor\Twig\Node\BodyNode([$body]), $arguments, $lineno, $this->getTag()));
        return new \ShopMagicVendor\Twig\Node\Node();
    }
    public function decideBlockEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endmacro');
    }
    public function getTag()
    {
        return 'macro';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\MacroTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Macro');
