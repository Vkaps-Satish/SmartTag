<?php
abstract class AbstractWooUserRoleModule
{
    protected $ecommerceFacade;
    protected static $_frontend;

    public function __construct()
    {
        $this->frontend = &static::$_frontend;
        $this->ecommerceFacade = EcommerceFactory::getInstance();
    }
}