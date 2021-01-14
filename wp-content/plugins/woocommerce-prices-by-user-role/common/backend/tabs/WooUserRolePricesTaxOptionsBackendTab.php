<?php

class WooUserRolePricesTaxOptionsBackendTab
    extends AbstractWooUserRolePricesBackendTab
{
    public function getOptionsFieldSet()
    {
        $options = $this->backend->getOptionsFieldSet('taxes');

        return $options;
    } // end getOptionsFieldSet
}