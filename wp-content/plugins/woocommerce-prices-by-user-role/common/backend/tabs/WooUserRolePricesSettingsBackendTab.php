<?php

class WooUserRolePricesSettingsBackendTab
    extends AbstractWooUserRolePricesBackendTab
{
    public function display()
    {
        parent::display();

        echo $this->backend->fetch('add_new_role_form.phtml');
    } // end display

    public function getOptionsFieldSet()
    {
        $options = $this->backend->getOptionsFieldSet();

        return $options;
    } // end getOptionsFieldSet
}