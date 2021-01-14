<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Twig\Extension;

use ShopMagicVendor\Twig\TwigFunction;
/**
 * @final
 */
class StringLoaderExtension extends \ShopMagicVendor\Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [new \ShopMagicVendor\Twig\TwigFunction('template_from_string', 'twig_template_from_string', ['needs_environment' => \true])];
    }
    public function getName()
    {
        return 'string_loader';
    }
}
\class_alias('ShopMagicVendor\\Twig\\Extension\\StringLoaderExtension', 'ShopMagicVendor\\Twig_Extension_StringLoader');
namespace ShopMagicVendor;

use ShopMagicVendor\Twig\Environment;
use ShopMagicVendor\Twig\TemplateWrapper;
/**
 * Loads a template from a string.
 *
 *     {{ include(template_from_string("Hello {{ name }}")) }}
 *
 * @param string $template A template as a string or object implementing __toString()
 * @param string $name     An optional name of the template to be used in error messages
 *
 * @return TemplateWrapper
 */
function twig_template_from_string(\ShopMagicVendor\Twig\Environment $env, $template, $name = null)
{
    return $env->createTemplate((string) $template, $name);
}
