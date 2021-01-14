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

use ShopMagicVendor\Twig\Node\FlushNode;
use ShopMagicVendor\Twig\Token;
/**
 * Flushes the output to the client.
 *
 * @see flush()
 *
 * @final
 */
class FlushTokenParser extends \ShopMagicVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\ShopMagicVendor\Twig\Token $token)
    {
        $this->parser->getStream()->expect(\ShopMagicVendor\Twig\Token::BLOCK_END_TYPE);
        return new \ShopMagicVendor\Twig\Node\FlushNode($token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'flush';
    }
}
\class_alias('ShopMagicVendor\\Twig\\TokenParser\\FlushTokenParser', 'ShopMagicVendor\\Twig_TokenParser_Flush');
