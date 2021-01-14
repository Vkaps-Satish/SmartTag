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

use ShopMagicVendor\Twig\Node\SpacelessNode;
use ShopMagicVendor\Twig\Token;
/**
 * Remove whitespaces between HTML tags.
 *
 *   {% spaceless %}
 *      <div>
 *          <strong>foo</strong>
 *      </div>
 *   {% endspaceless %}
 *   {# output will be <div><strong>foo</strong></div> #}
 *
 * @final
 */
class SpacelessTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideSpacelessEnd'], \true);
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        return new \ShopMagicVendor\Twig\Node\SpacelessNode($body, $lineno, $this->getTag());
    }
    public function decideSpacelessEnd(\ShopMagicVendor\Twig\Token $token)
    {
        return $token->test('endspaceless');
    }
    public function getTag()
    {
        return 'spaceless';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\SpacelessTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Spaceless');
