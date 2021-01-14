<?php

class UserRolePriceFacade implements IUserRolePriceFacade
{
    private static $_instance = null;
    
    const INDEX_PRODUCT_WITH_MINIMAL_PRICE = 0;
    const WOOCOMMERCE_QUERY_CLASS_NAME = 'WC_Query';
    const WORDPRESS_QUERY_CLASS_NAME = 'WP_Query';

    public static function &getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    } // end &getInstance
    
    public function __construct()
    {
         if (isset(self::$_instance)) {
            $message = 'Instance already defined ';
            $message .= 'use UserRolePriceFacade::getInstance';
            throw new Exception($message);
         }
    } // end __construct
    
    public function getRolePriceForWoocommercePriceSuffix(
        $product,
        $userRole,
        $engine,
        $engineFacade
    )
    {
        $idProduct = $this->_getVariationWithMinimalPrice(
            $product,
            $engineFacade
        );

        $minUserPrices = $this->_getUserRolePricesForProduct(
            $idProduct,
            $engine
        );

        if (!$minUserPrices) {
            $minUserPrices = array();
        }

        if ($this->_isSalePriceForUserRoleSet($minUserPrices, $userRole)) {
            return $this->_getSalePriceForUserRole($minUserPrices, $userRole);
        }
        
        return $this->_getRegularPriceForUserRole(
            $minUserPrices,
            $userRole
        );
    } // end getRolePriceForWoocommercePriceSuffix

    private function _getRegularPriceForUserRole($priceList, $userRole)
    {
        foreach ($priceList as $role => $price) {
            if ($role == $userRole) {
                return $price;
            }
        }

        return false;
    } // end _getRegularPriceForUserRole

    private function _getSalePriceForUserRole($priceList, $userRole)
    {
        foreach ($priceList['salePrice'] as $role => $price) {
            if ($role == $userRole) {
                return $price;
            }
        }

        return false;
    } // end _getSalePriceForUserRole

    private function _getUserRolePricesForProduct($idProduct, $engine)
    {
        return $engine->getMetaOptions(
            $idProduct,
            PRICE_BY_ROLE_PRICE_META_KEY
        );
    } // end _getUserRolePricesForProduct

    private function _getVariationWithMinimalPrice($product, $engineFacade)
    {
        $result = $engineFacade->getPricesFromVariationProduct($product);

        if (!empty($result)) {
            $result = array_keys($result, min($result));

            return $result[static::INDEX_PRODUCT_WITH_MINIMAL_PRICE];
        }

        return false;
    } // end _getVariationWithMinimalPrice

    private function _isSalePriceForUserRoleSet($priceList, $userRole)
    {
        return array_key_exists('salePrice', $priceList) &&
               !empty($priceList['salePrice'][$userRole]);
    } // end _isSalePriceForUserRoleSet

    private function _isUserRolePriceFilterRange($metaQuery, $frontend)
    {
        return array_key_exists('price_filter', $metaQuery) &&
               is_array($metaQuery['price_filter']['value']) &&
               $frontend->userRole;
    } // end _isUserRolePriceFilterRange

    private function _isRolePriceBetweenMinMax($rolePrice, $min, $max)
    {
        return $rolePrice && $rolePrice <= $max && $rolePrice >= $min;
    } // end _isRolePriceBetweenMinMax

    private function _getQueryClassName($query)
    {
        if (!is_object($query)) {
            return false;
        }

        $className = get_class($query);

        return $className;
    } // end _getQueryClassName

    private function _getProductsPriceFilterRangeByRole(
        $frontend,
        $metaQuery
    )
    {
        if (!$this->_isUserRolePriceFilterRange($metaQuery, $frontend)) {
            return $metaQuery;
        }

        $facade = EcommerceFactory::getInstance();

        list($min, $max) = $metaQuery['price_filter']['value'];

        $rolePrices = $frontend->getRolePricesForWidgetFilter();

        foreach ($rolePrices as $idProduct => $price) {
            if (!$this->_isRolePriceBetweenMinMax($price, $min, $max)) {
                continue;
            }
            $product = $frontend->createProductInstance($idProduct);
            $regularPrice = $facade->getRegularPrice($product);
            if ($regularPrice == 0 && $min > 0) {
                continue;
            }
            $regularPrices[] = $regularPrice;
        }

        if (!empty($regularPrices)) {
            $regularPriceRange[] = min($regularPrices);
            $regularPriceRange[] = max($regularPrices);
            $metaQuery['price_filter']['value'] = $regularPriceRange;
        } else {
            unset($metaQuery['price_filter']['compare']);
        }

        return $metaQuery;
    } // end _getProductsPriceFilterRangeByRole

    private function _isWooCommerceQuery($wordPressQuery, $eCommerceQuery)
    {
        $wordPressQueryClass = $this->_getQueryClassName($wordPressQuery);

        $eCommerceQueryClass = $this->_getQueryClassName($eCommerceQuery);

        return $eCommerceQueryClass == static::WOOCOMMERCE_QUERY_CLASS_NAME &&
               $wordPressQueryClass == static::WORDPRESS_QUERY_CLASS_NAME;
    } // end _isWooCommerceQuery

    public function updatePriceFilterQueryForProductsSearch(
        $wordPressQuery,
        $eCommerceQuery,
        $frontend
    )
    {
        if ($this->_isWooCommerceQuery($wordPressQuery, $eCommerceQuery)) {
            $metaQuery = $eCommerceQuery->get_meta_query();

            $priceRange = $this->_getProductsPriceFilterRangeByRole(
                $frontend,
                $metaQuery
            );

            $wordPressQuery->set('meta_query', $priceRange);
        }
    } // end updatePriceFilterQueryForProductsSearch

    public function getPriceByRolePriceFilter($price, $product, $engine)
    {
        $product = $engine->getProductNewInstance($product);

        if (!$engine->isRegisteredUser()) {
            return $price;
        }

        if (!$engine->hasUserRoleInActivePluginRoles()) {
            return $engine->getPriceWithFixedFloat($price);
        }

        $newPrice = $engine->getRolePriceOrSale($product);

        if ($newPrice) {
            return $engine->getPriceWithFixedFloat($newPrice);
        }

        $facade = EcommerceFactory::getInstance();

        if (
            $engine->isVariableTypeProduct($product) &&
            $facade->isEnabledTaxCalculation() &&
            $facade->hasPriceDisplaySuffixPriceIncludingOrExcludingTax()
        ) {
            return $this->getRolePriceForWoocommercePriceSuffix(
                $product,
                $engine->userRole,
                $engine,
                $facade
            );
        }

        return $price;
    } // end getPriceByRolePriceFilter
}