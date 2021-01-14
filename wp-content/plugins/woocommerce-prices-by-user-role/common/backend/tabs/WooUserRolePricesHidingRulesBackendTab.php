<?php

class WooUserRolePricesHidingRulesBackendTab
    extends AbstractWooUserRolePricesBackendTab
{
    public function getOptionsFieldSet()
    {
        $options = $this->backend->getOptionsFieldSet('hide');

        return $options;
    } // end getOptionsFieldSet
}