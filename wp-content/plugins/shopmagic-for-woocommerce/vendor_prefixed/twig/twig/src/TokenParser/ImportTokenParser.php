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

use ShopMagicVendor\Twig\Node\Expression\AssignNameExpression;
use ShopMagicVendor\Twig\Node\ImportNode;
use ShopMagicVendor\Twig\Token;
/**
 * Imports macros.
 *
 *   {% import 'forms.html' as forms %}
 *
 * @final
 */
class ImportTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $macro = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE, 'as');
        $var = new \ShopMagicVendor\Twig\Node\Expression\AssignNameExpression($this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::NAME_TYPE)->getValue(), $token->getLine());
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->addImportedSymbol('template', $var->getAttribute('name'));
        return new \ShopMagicVendor\Twig\Node\ImportNode($macro, $var, $token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'import';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\ImportTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Import');
