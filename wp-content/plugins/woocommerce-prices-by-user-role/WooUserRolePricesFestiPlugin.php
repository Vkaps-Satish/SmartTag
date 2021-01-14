<?php

class WooUserRolePricesFestiPlugin extends WpmlCompatibleFestiPlugin
{
    public $languageDomain = PRICE_BY_ROLE_LANGUAGE_DOMAIN;
    public $version = PRICE_BY_ROLE_VERSION;

    protected $optionsPrefix = PRICE_BY_ROLE_OPTIONS_PREFIX;
    protected $settings;
    protected $ecommerceFacade;
    protected $userRole;

    protected static $filterPrices = array();
    protected static $isSalePrices = array();

    const ENABLED_MULTI_CURRENCY_OPTION_VALUE = 2;
    const MAX_EXECUTION_TIME = 180;
    const FESTI_DEFAULT_TAX_KEY = 'defaultTax';
    const FESTI_EXCLUDE_ALL_TAX_KEY = 'excludeAllTax';
    const FESTI_EXCLUDE_TAX_IN_SHOP_KEY = 'excludeTaxInShop';
    const FESTI_EXCLUDE_TAX_IN_CART_AND_CHECKOUT_KEY =
        'excludeTaxInCartAndCheckout';

    protected function onInit()
    {
        $this->addActionListener('woocommerce_init', 'onInitTaxActions');

        $this->addActionListener('plugins_loaded', 'onLanguagesInitAction');

        if ($this->_isWoocommercePluginNotActiveWhenFestiPluginActive()) {
            $this->addActionListener(
                'admin_notices',
                'onDisplayInfoAboutDisabledWoocommerceAction' 
            );
            
            return false;
        }
        
        $this->onInitCompatibilityManager();

        $this->oInitWpmlManager();
   
        $this->addActionListener('wp_loaded', 'onInitStringHelperAction');
        
        if ($this->isWmplCurrenciesPluginActive()) {
            $this->_doIncludeWpmlCurrencyCompabilityManager();
        }

        if (!$this->isSessionStarted()) {
            session_start();
        }

        $this->ecommerceFacade = EcommerceFactory::getInstance();

        $this->addActionListener(
            'woocommerce_is_purchasable',
            'onProductPurchasable',
            10,
            2
        );

        $this->addActionListener(
            'woocommerce_variation_is_purchasable',
            'onProductPurchasable',
            10,
            2
        );

        parent::onInit();
    } // end onInit

    public function onInitTaxActions()
    {
        if ($this->isEnabledUserRoleTaxOptions()) {
            $this->addActionListener(
                'woocommerce_base_tax_rates',
                'onUserRoleBaseTaxRates'
            );

            $this->addActionListener(
                'woocommerce_matched_rates',
                'onUserRoleMatchedRates',
                10,
                2
            );

            $this->addActionListener(
                'woocommerce_settings_tax',
                'doRestoreDefaultDisplayTaxValues'
            );
        }
    }
    
    protected function isWmplCurrenciesPluginActive()
    {
        $plugin = 'woocommerce-multilingual/wpml-woocommerce.php';
        
        return $this->isPluginActive($plugin);
    } // end isWmplCurrenciesPluginActive
    
    private function _doIncludeWpmlCurrencyCompabilityManager()
    {
        $path = $this->_pluginPath.'/common/wpml/';
        $name = 'WpmlCurrencyCompabilityManager.php';
        $file = $path.$name;       
        $files = array($file);
       
        $this->doIncludeFiles($files);
    } // end _doIncludeWpmlCurrencyCompabilityManager
    
    protected function isWpmlMultiCurrencyOptionOn()
    {
        $facade = WordpressFacade::getInstance();

        $options = $facade->getOption('_wcml_settings');

        $key = 'enable_multi_currency';

        if (!$this->_isOptionExist($options, $key)) {
            return false;
        }
        
        $option = $options[$key];
        
        return $option == self::ENABLED_MULTI_CURRENCY_OPTION_VALUE &&
               $this->isWmplCurrenciesPluginActive();
               $this->isWmplTranslatePluginActive();
    } // end isWpmlMultiCurrencyOptionOn
    
    protected function isWmplTranslatePluginActive()
    {
        $plugin = 'wpml-translation-management/plugin.php';
        
        return $this->isPluginActive($plugin);
    } // end isWmplTranslatePluginActive
    
    private function _isOptionExist($options, $key)
    {
        if (!is_array($options)) {
            return false;
        }
        
        return array_key_exists($key, $options);
    } // end _isOptionExist
    
    public function doIncludeFiles($files)
    {
        foreach ($files as $file) {
            if (!file_exists($file)) {
                $message = "File does not exist: ".$file;
                throw new Exception($message);
            }
            
            require_once($file);
        }
    } // end doIncludeFiles
    
    protected function onInitCompatibilityManager()
    {
        $fileName = 'CompatibilityManagerWooUserRolePrices.php';
        require_once $this->_pluginPath.'common/'.$fileName;

        $pluginMainFile = $this->_pluginMainFile;
        new CompatibilityManagerWooUserRolePrices($pluginMainFile);
    } // end onInitCompatibilityManager
    
    protected function oInitWpmlManager()
    {
        new FestiWpmlManager(PRICE_BY_ROLE_WPML_KEY, $this->_pluginMainFile);
    } // end oInitWpmlManager
    
    public function onInitStringHelperAction()
    {
        $this->userRole = $this->getUserRole();

        StringManagerWooUserRolePrices::start();
    } // end onInitStringHelperAction
    
    public function onInstall()
    {
        if (!$this->_isWoocommercePluginActive()) {
            $this->onDisplayInfoAboutDisabledWoocommerceAction();
            return false;
        }

        $plugin = $this->onBackendInit();
        
        $plugin->onInstall();
    } // end onInstall
    
    public function onBackendInit()
    {
        $fileName = 'WooUserRolePricesBackendFestiPlugin.php';
        require_once $this->_pluginPath.$fileName;
        
        if (!class_exists("WooUserRoleDisplayPricesBackendManager")) {
            $fileName = 'WooUserRoleDisplayPricesBackendManager.php';
            require_once __DIR__.'/common/backend/'.$fileName;
        }
        
        $pluginMainFile = $this->_pluginMainFile;
        $backend = new WooUserRolePricesBackendFestiPlugin($pluginMainFile);

        return $backend;
    } // end onBackendInit
    
    protected function onFrontendInit()
    {
        $fileName = 'WooUserRolePricesFrontendFestiPlugin.php';
        require_once $this->_pluginPath.$fileName;
        $pluginMainFile = $this->_pluginMainFile;
        $frontend = new WooUserRolePricesFrontendFestiPlugin($pluginMainFile);

        return $frontend;
    } // end onFrontendInit
    
    private function _isWoocommercePluginNotActiveWhenFestiPluginActive()
    {
        return $this->_isPricesByUserRolePluginActive() &&
               !$this->_isWoocommercePluginActive();
    } // end _isWoocommercePluginNotActiveWhenFestiPluginActive
    
    private function _isPricesByUserRolePluginActive()
    {
        $plugin = 'woocommerce-prices-by-user-role/plugin.php';

        return $this->isPluginActive($plugin);
    } // end _isPricesByUserRolePluginActive
    
    private function _isWoocommercePluginActive()
    {
        return $this->isPluginActive('woocommerce/woocommerce.php');
    } // end _isWoocommercePluginActive
    
    public function onLanguagesInitAction()
    {
        load_plugin_textdomain(
            $this->languageDomain,
            false,
            $this->_pluginLanguagesPath
        );
    } // end onLanguagesInitAction
    
    public function getMetaOptions($id, $optionName)
    {
        $value = $this->getPostMeta($id, $optionName);

        if (!$value) {
            $optionName = strtolower($optionName);
            $value = $this->getPostMeta($id, $optionName);
        }

        if (!$value) {
            return false;
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        $value = json_decode($value, true);
        
        return $value;
    } // end getMetaOptions
    
    public function getActiveRoles()
    {
        $options = $this->getOptions('settings');
        
        if (!$this->_hasActiveRoleInOptions($options)) {
            return false;
        }

        $wordpressRoles = $this->getUserRoles();
        
        $diff = array_diff_key($wordpressRoles, $options['roles']);
        $roles = array_diff_key($wordpressRoles, $diff);
        
        return $roles;
    } // end getActiveRoles
    
    private function _hasActiveRoleInOptions($options)
    {
        return array_key_exists('roles', $options);
    } // end _hasActiveRoleInOptions
    
    public function getUserRoles()
    {
        if (!$this->_hasRolesInGlobals()) {
            return false;
        }
        
        $roles = $GLOBALS['wp_roles'];

        return $roles->roles; 
    } // getUserRoles
    
    private function _hasRolesInGlobals()
    {
        return array_key_exists('wp_roles', $GLOBALS);   
    } // end _hasRolesInGlobals
    
    public function onDisplayInfoAboutDisabledWoocommerceAction()
    {        
        $message = 'The Prices By User Role plugin requires ';
        $message .= 'WooCommerce Plugin installed and activated.';
        $this->displayUpdate($message);
    } //end onDisplayInfoAboutDisabledWoocommerceAction
    
    public function updateMetaOptions($idPost, $value, $optionName)
    {
        $value = json_encode($value);

        $facade = WordpressFacade::getInstance();

        $facade->updatePostMeta($idPost, $optionName, $value);
    } // end updateMetaOptions
    
    public function updateProductPrices($idPost, $prices)
    {
        $this->updateMetaOptions(
            $idPost, 
            $prices,
            PRICE_BY_ROLE_PRICE_META_KEY
        );
    } // end updateProductPrices
    
    public function getProductPrices($idProduct)
    {
        return $this->getMetaOptionsForProduct(
            $idProduct, 
            PRICE_BY_ROLE_PRICE_META_KEY
        );
    } // end getProductPrices
    
    public function isIgnoreDiscountForProduct($idProduct = false)
    {
        return (bool) $this->getMetaOptionsForProduct(
            $idProduct,
            PRICE_BY_ROLE_IGNORE_DISCOUNT_META_KEY
        );
    } // end isIgnoreDiscountForProduct
    
    public function getMetaOptionsForProduct($idProduct, $optionName)
    {
        if (!$idProduct) {
            $post = $this->getWordpressPostInstance();
            $idProduct = $post->ID;
        }
    
        $values = $this->getMetaOptions($idProduct, $optionName);
        
        if (!$values) {
            $values = array();
        }
    
        return $values;
    } // end getMetaOptionsForProduct
    
    public function &getWordpressPostInstance()
    {
        return $GLOBALS['post'];
    } // end getWordpressPostInstance

    public function getPostMeta($idPost, $key, $single = true)
    {
        return get_post_meta($idPost, $key, $single);
    } // end getPostMeta
    
    public function getUserRole($idUser = false)
    {
        $roles = $this->getAllUserRoles($idUser);
    
        if (!$roles) {
            return false;
        }
    
        return array_shift($roles);
    } // end getUserRole
    
    public function getAllUserRoles($idUser = false)
    {
        if (!$idUser) {
            $idUser = $this->getUserID();
        }
    
        if (!$idUser) {
            return false;
        }
    
        $userData = get_userdata($idUser);

        if (!$userData) {
            return false;
        }
    
        return $userData->roles;
    } // end getAllUserRoles
    
    public function getUserID()
    {
        if (defined('DOING_AJAX') && $this->_hasUserIDInSessionArray()) {
            return $_SESSION['idUserForAjax'];
        }
    
        $idUser = get_current_user_id();
    
        return $idUser;
    } // end getUserID
    
    private function _hasUserIDInSessionArray()
    {
        return isset($_SESSION['idUserForAjax']);
    } // end _hasUserIDInSessionArray
    
    public function getRolePrice($idProduct, $idUser = false)
    {
        $roles = $this->getAllUserRoles($idUser);
    
        if (!$roles) {
            return false;
        }
        
        $priceList = $this->getProductPrices($idProduct);
    
        if (!$priceList) {
            return false;
        }
    
        $prices = $this->_getUserPrices($priceList, $roles, $idProduct);

        if (!$prices) {
            return false;
        }

        return min($prices);
    } // end getRolePrice
    
    private function _getUserPrices($priceList, $roles, $id)
    {
        if ($this->isWpmlMultiCurrencyOptionOn()) {
            return $this->_getWpmlMultiCurrencyRolePrices(
                $priceList,
                $roles,
                $id
            );
        }
    
        return $this->getAllRolesPrices($priceList, $roles);
    } // end _getUserPrices
    
    protected function getAllRolesPrices($priceList, $roles)
    {
        $prices = array();

        foreach ($roles as $key => $role) {
            if (!$this->hasRolePriceInProductOptions($priceList, $role)) {
                continue;
            }
        
            $prices[]= $this->getPriceWithFixedFloat($priceList[$role]);
        }
        
        return $prices;
    } // end getAllRolesPrices
    
    public function getRoleSalePrice($idProduct, $idUser=false)
    {
        $roles = $this->getAllUserRoles($idUser);
        
        if (!$roles) {
            return false;
        }
        
        $priceList = $this->getProductPrices($idProduct);
            
        $prices = array();
        
        foreach ($roles as $key => $role) {            
            if ($this->_hasSalePriceForUserRole($priceList, $role)) {
                $prices[] = $this->getPriceWithFixedFloat(
                    $priceList['salePrice'][$role]
                );
            }
        }

        if ($this->isWpmlMultiCurrencyOptionOn()) {
            $prices = $this->_getWpmlMultiCurrencyRolePrices(
                $priceList,
                $roles,
                $idProduct,
                true
            );
        }

        if ($prices) {
            return min($prices);    
        }
        
        return false;
    } // end getRoleSalePrice

    private function _getWpmlMultiCurrencyRolePrices(
        $priceList,
        $roles,
        $idProduct,
        $salePrices = false)
    {
        $wpmlCurrencyManager = new WpmlCurrencyCompabilityManager($this);
        return $wpmlCurrencyManager->getPrices(
            $priceList,
            $roles,
            $idProduct,
            $salePrices
        );
    } // end _getWpmlMultiCurrencyRolePrices
    
    private function _hasSalePriceForUserRole($priceList, $role)
    {
        return $this->hasRolePriceInProductOptions($priceList, $role) &&
               !$this->isDiscountOrMarkupEnabledByRole($role) &&
               $this->_hasExistSalePriceForUserRole($priceList, $role) &&
               $this->_hasScheduleForSalePriceRole($priceList, $role);
    } // end _hasSalePriceForUserRole
    
    private function _hasExistSalePriceForUserRole($priceList, $role)
    {
        return array_key_exists('salePrice', $priceList) &&
               array_key_exists($role, $priceList['salePrice']) &&
               !empty($priceList['salePrice'][$role]);
    } // end _hasExistSalePriceForUserRole
    
    private function _hasScheduleForSalePriceRole($priceList, $role)
    {
        if ($this->_hasScheduleFiledForSalePrice($priceList, $role)) {
            $dateNow = time();
            
            $dateFrom = $this->_getTimeSalePrice(
                $priceList,
                $role,
                'date_from'
            );

            $dateTo = $this->_getTimeSalePrice($priceList, $role, 'date_to');
            
            if ($dateFrom && $dateTo) {
                return ($dateNow >= $dateFrom && $dateNow <= $dateTo);
            } else if ($dateFrom && !$dateTo) {
                return ($dateNow >= $dateFrom);    
            } else if (!$dateFrom && $dateTo) {
                return ($dateNow <= $dateTo);
            }
        }
        
        return true;
    } // end _hasScheduleForSalePriceRole
    
    private function _getTimeSalePrice($priceList, $role, $dateName)
    {
        $date = 0;
        if (array_key_exists($dateName, $priceList['schedule'][$role])) {
            $date = strtotime($priceList['schedule'][$role][$dateName]);
        }
        
        return $date; 
    } // end _getTimeSalePrice
    
    private function _hasScheduleFiledForSalePrice($priceList, $role)
    {
        return array_key_exists('schedule', $priceList) &&
               array_key_exists($role, $priceList['schedule']);
    } // end _hasScheduleFiledForSalePrice
    
    public function getPriceWithFixedFloat($price)
    {
        $price = str_replace(',', '.', $price);
        $price = floatval($price);

        return strval($price);
    } // end getPriceWithFixedFloat
    
    protected function hasRolePriceInProductOptions($priceList, $role)
    {
        return array_key_exists($role, $priceList) && $priceList[$role];
    } // end hasRolePriceInProductOptions

    public function hasDiscountOrMarkUpForUserRoleInGeneralOptions(
        $userRole = false, $idUser = false
    )
    {
        if (!$userRole) {
            $userRole = $this->getUserRole($idUser);
        }
        
        if (!$userRole) {
            return false;
        }
    
        $settings = $this->getSettings();
    
        return array_key_exists('discountByRoles', $settings) && 
               array_key_exists($userRole, $settings['discountByRoles']) && 
               $settings['discountByRoles'][$userRole]['value'] != false;
    } // end hasDiscountOrMarkUpForUserRoleInGeneralOptions
    
    public function isDiscountOrMarkupEnabledByRole($role)
    {
        if (empty($role)) {
            return false;
        }
        
        $settings = $this->getSettings();
        
        if (!array_key_exists('discountByRoles', $settings)) {
            return false;
        }
        
        $discountByRoles = $settings['discountByRoles'];

        if (!array_key_exists($role, $discountByRoles)) {
            return false;
        }
        
        return (bool) $discountByRoles[$role]['value'];
    } // end isDiscountOrMarkupEnabledByRole
    
    protected function getSettings()
    {
        if (!$this->settings) {
            $settings = $this->getOptions('settings');
            $this->settings = $settings;
        }

        if (!$this->settings) {
            throw new Exception('The settings can not be empty.');
        }

        return $this->settings;
    } // end getSettings
    
    public function getRolePricesVariableProductByPriceType($product, $type)
    {
        if (!$this->isVariableTypeProduct($product)) {
            return false;
        }

        $facade = WooCommerceFacade::getInstance();

        $productsIDs = $facade->getVariationChildrenIDs($product);
        
        if (!$productsIDs) {
            return false;
        }

        $prices = array();
        
        foreach ($productsIDs as $id) {
            $productChild = $this->createProductInstance($id);
            if (!$this->hasProductID($productChild)) {
                continue;
            }

            if ($this->_isRolePriceTypeRegular($type)) {
                $price = $this->getPrice($productChild);
            } else {
                $price = $this->getSalePrice($productChild); 
            }
            
            if (!$price) {
                continue;
            }
            
            if ($this->isIncludingTaxesToPrice()) {
                $price = $facade->doIncludeTaxesToPrice($product, $price);
            }
            
            $prices[] = $price;
        }
        
        return $prices;
    } // end getRolePricesVariableProductByPriceType

    protected function isIncludingTaxesToPrice()
    {
        $facade = WooCommerceFacade::getInstance();
        
        return $facade->isEnabledTaxCalculation() &&
               !$facade->isPricesEnteredWithTax();
    } // end isIncludingTaxesToPrice
    
    private function _isRolePriceTypeRegular($type)
    {
        return $type == PRICE_BY_ROLE_TYPE_PRODUCT_REGULAR_PRICE;
    } // end _isRolePriceTypeRegular
    
    public function hasRoleRegularPriceByVariableProduct($product)
    {
        $rolePrices = $this->getRolePricesVariableProductByPriceType(
            $product,
            PRICE_BY_ROLE_TYPE_PRODUCT_REGULAR_PRICE
        );

        return (bool) $rolePrices;
    } // end hasRoleRegularPriceByVariableProduct
    
    public function hasRoleSalePriceByVariableProduct($product)
    {
        $rolePrices = $this->getRolePricesVariableProductByPriceType(
            $product,
            PRICE_BY_ROLE_TYPE_PRODUCT_SALE_PRICE
        );

        return (bool) $rolePrices;
    } // end hasRoleSalePriceByVariableProduct

    protected function isSessionStarted()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE;
            } else {
                return session_id() !== '';
            }
        } else if (defined('WP_TESTS_TABLE_PREFIX')) {
            return true;
        }
        
        return false;
    } // end isSessionStarted
    
    protected function getProductsInstances()
    {
        return new FestiWooCommerceProduct($this);
    } // end getProductsInstances
    
    protected function onFilterPriceByRolePrice()
    {
        $this->products->onFilterPriceByRolePrice();
    } // end onFilterPriceByRolePrice
    
    protected function onFilterPriceByDiscountOrMarkup()
    {
        $this->products->onFilterPriceByDiscountOrMarkup();
    } // end onFilterPriceByDiscountOrMarkup
    
    public function onDisplayPriceByRolePriceFilter($price, $product)
    {
        $id = $this->ecommerceFacade->getProductID($product);
        
        if (!empty(static::$filterPrices[$id])) {
            return static::$filterPrices[$id];
        }

        $priceFacade = UserRolePriceFacade::getInstance();

        $price = $priceFacade->getPriceByRolePriceFilter(
            $price,
            $product,
            $this
        );

        static::$filterPrices[$id] = $price;
        
        return $price;
    } // end onDisplayPriceByRolePriceFilter

    public function hasUserRoleInActivePluginRoles()
    {
        $roles = $this->getAllUserRoles();
        
        if (!$roles) {
            return false;
        }
        
        $activeRoles = $this->getActiveRoles();

        if (!$activeRoles) {
            return false;
        }

        $result = $this->_hasOneOfUserRolesInActivePLuginRoles(
            $activeRoles,
            $roles
        );
        
        return $result;
    } // end hasUserRoleInActivePluginRoles
    
    private function _hasOneOfUserRolesInActivePLuginRoles($activeRoles, $roles)
    {
        foreach ($roles as $key => $role) {
            $result = array_key_exists($role, $activeRoles);
            
            if ($result) {
                return $result;
            }
        }

        return false;
    } // end _hasOneOfUserRolesInActivePLuginRoles
    
    public function getRolePriceOrSale($product)
    {
        $salePrice = $this->getSalePrice($product);
        
        if ($salePrice && $salePrice > 0) {
            return $salePrice;
        }
        
        return $this->getPrice($product);
    } // end getRolePriceOrSale
    
    public function getProductNewInstance($product)
    { 
        $params = array(
            'product_type' => $this->ecommerceFacade->getProductType($product)
        );
        
        $idProduct = $this->getProductIDFromProductInstance($product);
       
        if (!$idProduct) {
            throw new Exception('Undefined product Id');
        }

        return $this->createProductInstance($idProduct, $params);
    } // end getProductNewInstance
    
    protected function getProductIDFromProductInstance($product)
    {
        $facade = &$this->ecommerceFacade;

        if ($this->_hasVariationIDInProductInstance($product)) {
            $idProduct = $facade->getVariationProductID($product);
        } else {
            $idProduct = $facade->getProductID($product);
        }
        
        return $idProduct;
    } // end getProductIDFromProductInstance
    
    private function _hasVariationIDInProductInstance($product)
    {
        return (bool) $this->ecommerceFacade->getVariationProductID($product);
    } // end _hasVariationIDInProductInstance

    public function createProductInstance($idProduct)
    {
        $facade = $this->ecommerceFacade;

        return $facade->getProductByID($idProduct);
    } // end createProductInstance
    
    public function getPrice($product)
    {
        return $this->products->getRolePrice($product);
    } // end getPrice
    
    public function getSalePrice($product)
    {
        return $this->products->getRoleSalePrice($product);
    } // end getSalePrice
    
    public function isRegisteredUser()
    {
        if (!isset($this->userRole)) {
            return false;
        }

        return $this->userRole;
    } // end isRegisteredUser
    
    public function isVariableTypeProduct($product)
    {
        return $this->ecommerceFacade->getProductType($product) == 'variable';
    }  // end isVariableTypeProduct
    
    public function getPriceWithDiscountOrMarkUp(
        $product, $originalPrice, $isSalePrice = true
    )
    {
        $amount = $this->getAmountOfDiscountOrMarkUp();
       
        $idPost = $this->ecommerceFacade->getProductID($product);

        if ($this->ecommerceFacade->getVariationProductID($product)) {
            $idPost = $this->ecommerceFacade->getVariationProductID($product);
        }
        
        if ($this->isIgnoreDiscountForProduct($idPost)) {
            $rolePrice = $this->getRolePrice($idPost);
            return $rolePrice ? $rolePrice : $originalPrice;
        }
       
        $isNotRoleDiscountType = false;
        $price = PRICE_BY_ROLE_PRODUCT_MINIMAL_PRICE;
        
        if ($this->isRolePriceDiscountTypeEnabled()) {
            $price = $this->getPrice($product);
            
            if (!$price) {
                $isNotRoleDiscountType = true;
            }
        }

        if (!$price) {
            $price = $this->products->getRegularPrice($product);
            
            if ($isSalePrice && $this->isAllowSalePrices($product)) {
                $price = $this->ecommerceFacade->getSalePrice($product);
                static::$isSalePrices[$idPost] = true;
            }
        }
        
        if ($isNotRoleDiscountType) {
            return $price;
        }
        
        if ($this->isPercentDiscountType()) {
            $amount = $this->getAmountOfDiscountOrMarkUpInPercentage(
                $price,
                $amount
            );
        }

        if ($this->isDiscountTypeEnabled()) {
            $minimalPrice = PRICE_BY_ROLE_PRODUCT_MINIMAL_PRICE;
            $newPrice = ($amount > $price) ? $minimalPrice : $price - $amount;
        } else {
            $newPrice = $price + $amount;
        }
        
        $numberOfDecimals = $this->ecommerceFacade->getNumberOfDecimals();
        
        if (!$numberOfDecimals) {
            $newPrice = round($newPrice);
        }

        return $newPrice;
    } // end getPriceWithDiscountOrMarkUp
    
    public function getAmountOfDiscountOrMarkUp()
    {
        $settings = $this->getSettings();
       
        if (!$this->_hasOptionByDiscountRoles('value', $settings)) {
            return false;
        }
        return $settings['discountByRoles'][$this->userRole]['value'];
    } // end getAmountOfDiscountOrMarkUp
    
    private function _hasOptionByDiscountRoles($option, $settings)
    {
        $role = $this->userRole;

        return array_key_exists('discountByRoles', $settings) &&
               array_key_exists($role, $settings['discountByRoles']) &&
               array_key_exists($option, $settings['discountByRoles'][$role]);
    } // end _hasOptionByDiscountRoles
    
    protected function isPercentDiscountType()
    {
        $settings = $this->getSettings();
        
        if (!$this->_hasOptionByDiscountRoles('type', $settings)) {
            return false;
        }
        
        $discountType = $settings['discountByRoles'][$this->userRole]['type'];

        return $discountType == PRICE_BY_ROLE_PERCENT_DISCOUNT_TYPE;
    } // end isPercentDiscountType
    
    protected function isRolePriceDiscountTypeEnabled()
    {
        $settings = $this->getSettings();
        $userRole = $this->userRole;
        
        if (!$settings) {
            return false;
        }
        
        if (!isset($settings['discountByRoles'][$userRole]['priceType'])) {
            return false;
        }
        
        $priceType = $settings['discountByRoles'][$userRole]['priceType'];
        
        return $priceType == PRICE_BY_ROLE_DISCOUNT_TYPE_ROLE_PRICE;
    } // end isRolePriceDiscountTypeEnabled
    
    protected function isAllowSalePrices($product)
    {
        return $this->isEnableBothRegularSalePriceSetting() && 
               $this->hasSalePrice($product);
    } // end isAllowSalePrices
    
    protected function isEnableBothRegularSalePriceSetting()
    {
        $settings = $this->getSettings();

        return array_key_exists('bothRegularSalePrice', $settings) && 
               $settings['bothRegularSalePrice'] &&
               $this->hasDiscountOrMarkUpForUserRoleInGeneralOptions();
    } // end isEnableBothRegularSalePriceSetting
    
    protected function hasSalePrice($product)
    {
        return (bool) $this->ecommerceFacade->getSalePrice($product);
    } // end hasSalePrice
    
    public function getAmountOfDiscountOrMarkUpInPercentage($price, $discount)
    {
        $discount = $price / 100 * $discount;
        
        return $discount;
    } // end getAmountOfDiscountOrMarkUpInPercentage
    
    protected function isDiscountTypeEnabled()
    {
        $settings = $this->getSettings();

        return $settings['discountOrMakeUp'] == 'discount';
    } // end isDiscountTypeEnabled

    public function onDisplayPriceByDiscountOrMarkupFilter($price, $product)
    {
        $product = $this->getProductNewInstance($product);

        if (!$this->isRegisteredUser()) {
            return $price;
        }

        $newPrice = $this->getPriceWithDiscountOrMarkUp($product, $price);

        $price = $this->getPriceWithFixedFloat($newPrice);

        return $price;
    } // end onDisplayPriceByDiscountOrMarkupFilter

    public function hasHideAllProductsOptionInSettings()
    {
        $settings = $this->getOptions('settings');

        return array_key_exists('hideAllProducts', $settings) &&
               $settings['hideAllProducts'];
    } //end hasHideAllProductsOptionInSettings

    public function onProductPurchasable($result, $product)
    {
        $facade = $this->ecommerceFacade;

        $idProduct = $facade->getProductID($product);

        $regularPrice = $facade->getRegularPrice($product);

        if ($regularPrice) {
            return $result;
        }

        $rolePrice = $this->getRolePrice($idProduct);

        if (!$rolePrice) {
            return $result;
        };

        return $facade->isProductExists($product) &&
               $facade->isAllowProductEdit($product);
    } // end onProductPurchasable

    protected function isEnabledUserRoleTaxOptions()
    {
        $facade = WooCommerceFacade::getInstance();

        if (!$facade->isEnabledTaxCalculation()) {
            return false;
        }

        $settings = $this->getOptions('settings');

        return array_key_exists('taxOptions', $settings) &&
               $settings['taxOptions'];
    } //end isEnabledUserRoleTaxOptions

    public function onUserRoleBaseTaxRates($rate)
    {
        $taxClass = $this->_getUserRoleTaxClass();

        if (!$taxClass) {
            return $rate;
        }

        $facade = WooCommerceFacade::getInstance();

        $args = array(
            'country' => $facade->getBaseCountry(),
            'state' => $facade->getBaseState(),
            'postcode' => $facade->getBasePostCode(),
            'city' => $facade->getBaseCity(),
            'tax_class' => $taxClass
        );

        return $facade->findTaxRates($args);
    } // end onUserRoleBaseTaxRates

    protected function getTaxByUserRoleOptions()
    {
        $settings = $this->getOptions('settings');

        $userRole = $this->userRole;

        if (!$userRole) {
            return false;
        }

        $taxByUserRoles = $settings['taxByUserRoles'];

        if ($this->_hasUserRoleInTaxOptions($userRole, $taxByUserRoles)) {
            return $taxByUserRoles[$userRole];
        }

        return false;
    } //end getTaxByUserRoleOptions

    private function _hasUserRoleInTaxOptions($userRole, $options)
    {
        return array_key_exists($userRole, $options);
    } //end _hasUserRoleInTaxOptions

    public function onUserRoleMatchedRates($taxClass = '', $customer = null)
    {
        $taxClass = $this->_getUserRoleTaxClass();

        $facade = WooCommerceFacade::getInstance();

        $location = $facade->getTaxLocation($taxClass, $customer);

        $matchedTaxRates = array();

        if ($this->_isTaxLocationFieldsExist($location)) {
            list($country, $state, $postcode, $city) = $location;

            $args = array(
                'country' => $country,
                'state' => $state,
                'postcode' => $postcode,
                'city' => $city,
                'tax_class' => $taxClass,
            );

            $matchedTaxRates = $facade->findTaxRates($args);
        }

        return $matchedTaxRates;
    } //end onUserRoleMatchedRates

    private function _getUserRoleTaxClass()
    {
        if (!$this->isRegisteredUser()) {
            return false;
        };

        if (!$this->isEnabledUserRoleTaxOptions()) {
            return false;
        }

        $facade = WooCommerceFacade::getInstance();

        $settings = $this->getTaxByUserRoleOptions();

        if (!$settings) {
            return false;
        }

        $key = $settings['taxClass'];

        $taxClasses = $facade->getTaxClasses();

        $taxClass = false;

        if ($key) {
            $taxClass = $taxClasses[$key];
            $taxClass = sanitize_title($taxClass);
        }

        return $taxClass;
    } //end _getUserRoleTaxClass

    private function _isTaxLocationFieldsExist($location)
    {
        return sizeof($location) == 4;
    } //end _isTaxLocationFieldsExist

    public function doRestoreDefaultDisplayTaxValues()
    {
        $wordPressFacade = WordpressFacade::getInstance();

        if (!$this->isUserRoleDisplayTaxOptionExist()) {
            return false;
        }

        $options = $wordPressFacade->getOption(
            PRICE_BY_ROLE_TAX_DISPLAY_OPTIONS
        );

        $wooCommerceFacade = WooCommerceFacade::getInstance();

        list($shopHookName, $cartHookName)
            = $wooCommerceFacade->getDisplayTaxHookNames();

        $wordPressFacade->updateOption(
            $shopHookName,
            $options[$shopHookName]
        );

        $wordPressFacade->updateOption(
            $cartHookName,
            $options[$cartHookName]
        );
    } // doRestoreDefaultDisplayTaxValues

    protected function isUserRoleDisplayTaxOptionExist()
    {
        $facade = WordpressFacade::getInstance();

        return $facade->getOption(PRICE_BY_ROLE_TAX_DISPLAY_OPTIONS);
    } // end isUserRoleDisplayTaxOptionExist

    private function _getMaxExecutionTime()
    {
        return ini_get('max_execution_time');
    } // end _getMaxExecutionTime

    protected function isMaxExecutionTimeLowerThanConstant()
    {
        $executionTime = static::MAX_EXECUTION_TIME;

        return $this->_getMaxExecutionTime() < $executionTime;
    } // end isMaxExecutionTimeLowerThanConstant
}