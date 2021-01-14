<?php

class CsvWooProductsExporter extends WooUserRolePricesFestiPlugin
{
    private $_userRoles;
    private $_ecommerceFacade;
    private $_exportColumnNames;

    const PRICE_SUFFIX_KEY = '_price';
    const SALE_PRICE_SUFFIX_KEY = '_sale_price';

    public function __construct()
    {
        $this->_ecommerceFacade = EcommerceFactory::getInstance();

        $this->addActionListener('plugins_loaded', 'onPrepareUserRoles');

        $this->onInitExportListeners();
    } // end __construct

    public function onInitExportListeners()
    {
        $this->addActionListener(
            'woocommerce_init',
            'onInitDefaultExportNames'
        );

        $this->addActionListener(
            'wp_ajax_woocommerce_do_ajax_product_export',
            'onInitDefaultExportNames'
        );
    } // end onInitExportListeners

    public function onInitDefaultExportNames()
    {
        $facade = $this->_ecommerceFacade;

        $this->_exportColumnNames = $facade->getDefaultColumnNamesForExport();

        $this->addActionListener(
            'woocommerce_product_export_product_default_columns',
            'onExportDefaultColumns'
        );

        $this->addActionListener(
            'woocommerce_product_export_skip_meta_keys',
            'onExportSkipMetaKeys',
            10,
            2
        );

        $this->onInitExportColumnFilters();
    } // end onInitDefaultExportNames

    public function onExportDefaultColumns()
    {
        $columnNames = $this->_exportColumnNames;

        $userRoles = $this->_userRoles;

        foreach ($userRoles as $key => $roleName) {
            $priceSuffix = __('Price', $this->languageDomain);
            $salePriceSuffix = __('Sale Price', $this->languageDomain);

            $keyPrice = $key.static::PRICE_SUFFIX_KEY;
            $columnNames[$keyPrice] = "{$roleName} {$priceSuffix}";
            $keySalePrice = $key.static::SALE_PRICE_SUFFIX_KEY;
            $columnNames[$keySalePrice] = "{$roleName} {$salePriceSuffix}";
        }

        return $columnNames;
    } // end onExportDefaultColumns

    public function onFilterExportColumnValue($value, $product, $columnName)
    {
        $facade = $this->_ecommerceFacade;

        $idProduct = $facade->getProductID($product);

        $userRole = $this->_getUserRoleFromExportColumn($columnName);

        $priceList = $this->getProductPrices($idProduct);

        if (!$this->hasRolePriceInProductOptions($priceList, $userRole)) {
            return false;
        };

        if ($this->_isSalePriceColumn($columnName)) {
            $priceList = $priceList['salePrice'];
        }

        return $priceList[$userRole];
    } // end onFilterExportColumnValue

    public function onPrepareUserRoles()
    {
        $userRoles = $this->getUserRoles();

        if (!$userRoles) {
            $userRoles = array();
        }

        foreach ($userRoles as $key => $role) {
            $userRoles[$key] = $role['name'];
        }

        $this->_userRoles = $userRoles;
    } // end onPrepareUserRoles

    private function _getUserRoleFromExportColumn($name)
    {
        $search = array(
            static::SALE_PRICE_SUFFIX_KEY,
            static::PRICE_SUFFIX_KEY
        );

        return str_replace($search,'',$name);
    } // end _getUserRoleFromExportColumn

    private function _isSalePriceColumn($name)
    {
        return strpos($name, static::SALE_PRICE_SUFFIX_KEY) !== false;
    } // end _isSalePriceColumn

    public function onInitExportColumnFilters()
    {
        $userRoles = $this->_userRoles;

        $exportColumnHookName = 'woocommerce_product_export_product_column_';

        foreach ($userRoles as $roleKey => $roleName) {
            $this->addFilterListener(
                $exportColumnHookName.$roleKey.static::PRICE_SUFFIX_KEY,
                'onFilterExportColumnValue',
                10,
                3
            );

            $this->addFilterListener(
                $exportColumnHookName.$roleKey.static::SALE_PRICE_SUFFIX_KEY,
                'onFilterExportColumnValue',
                10,
                3
            );
        }
    } // end onInitExportColumnFilters

    public function onExportSkipMetaKeys($metaKeys, $product)
    {
        $metaKeys[] = PRICE_BY_ROLE_PRICE_META_KEY;

        return $metaKeys;
    } // end onExportSkipMetaKeys
}