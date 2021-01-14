<?php

/*
 * Need to compability with plugin Product Bundles
 * @link http://www.woothemes.com/products/product-bundles/
 */

class FestiWooCommerceBundleProduct extends FestiWooCommerceSimpleProduct
{
    public function isAvaliableToDisplaySaleRange($product)
    {
        return !$this->_hasRolePriceForCurrentUser($product);
    } // end isAvaliableToDisplaySaleRange
    
    private function _hasRolePriceForCurrentUser($product)
    {
        $listOfProducts = $this->adapter->getListOfPruductsWithRolePrice();
        $idProduct = $this->getProductID($product);
        return in_array($idProduct, $listOfProducts);
    } // end _hasRolePriceForCurrentUser
    
    public function getFormatedPriceForSaleRange($product, $userPrice)
    {
        return wc_price($userPrice);
    } // end getFormatedPriceForSaleRange
}
