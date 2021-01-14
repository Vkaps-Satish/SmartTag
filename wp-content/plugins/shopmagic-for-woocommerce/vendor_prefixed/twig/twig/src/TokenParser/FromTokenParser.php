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
use ShopMagicVendor\Twig\Node\Expression\AssignNameExpression;
use ShopMagicVendor\Twig\Node\ImportNode;
use ShopMagicVendor\Twig\Token;
/**
 * Imports macros.
 *
 *   {% from 'forms.html' import forms %}
 *
 * @final
 */
class FromTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $macro = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();
        $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'import');
        $targets = [];
        do {
            $name = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
            $alias = $name;
            if ($stream->nextIf('as')) {
                $alias = $stream->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue();
            }
            $targets[$name] = $alias;
            if (!$stream->nextIf(\ShopMagicVendor\Twig\Token::PUNCTUATION_TYPE, ',')) {
                break;
            }
        } while (\true);
        $stream->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $var = new \ShopMagicVendor\Twig\Node\Expression\AssignNameExpression($this->parser->getVarName(), $token->getLine());
        $node = new \ShopMagicVendor\Twig\Node\ImportNode($macro, $var, $token->getLine(), $this->getTag());
        foreach ($targets as $name => $alias) {
            if ($this->parser->isReservedMacroName($name)) {
                throw new \ShopMagicVendor\Twig\Error\SyntaxError(\sprintf('"%s" cannot be an imported macro as it is a reserved keyword.', $name), $token->getLine(), $stream->getSourceContext());
            }
            $this->parser->addImportedSymbol('function', $alias, 'get' . $name, $var);
        }
        return $node;
    }
    public function getTag()
    {
        return 'from';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\FromTokenParser', 'ShopMagicVendor\\Twig_TokenParser_From');
