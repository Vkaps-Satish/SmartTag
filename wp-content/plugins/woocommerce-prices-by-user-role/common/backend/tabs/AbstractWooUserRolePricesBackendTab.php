<?php

class AbstractWooUserRolePricesBackendTab
{
    protected $backend;

    private $_errorMessage;
    private $_hasErrors = false;

    public function __construct(&$backend)
    {
        $this->backend = &$backend;
    }

    public function display()
    {
        $vars = $this->_getCurrentValues();

        echo $this->backend->fetch('settings_page.phtml', $vars);
    } // end display

    public function getOptionsFieldSet()
    {
        $options = $this->backend->getOptionsFieldSet();

        return $options;
    } // end getOptionsFieldSet

    public function doUpdateOptions($params)
    {
        try {
            $this->backend->updateOptions('settings', $params);
        } catch (Exception $e) {
            $this->_hasErrors = true;
            $this->_errorMessage = $e->getMessage();

            return false;
        }

        return true;
    } // end doUpdateOptions

    private function _getCurrentValues()
    {
        $options = $this->backend->getOptions('settings');

        $vars['fieldset'] = $this->getOptionsFieldSet();
        $vars['currentValues'] = $options;

        return $vars;
    } // end _getCurrentValues

    public function getLastError()
    {
        if ($this->_hasErrors) {
            return $this->_errorMessage;
        }

        return false;
    } // end getLastError
}