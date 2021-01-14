<?php

class FestiWooCommerceUnknownProduct extends AbstractFestiWooCommerceProduct
{
    public function getProductID($product)
    {
        return $this->ecommerceFacade->getProductID($product);
    } // end getProductID

    public function removeAddToCartButton()
    {
        $this->wordpressFacade->onRemoveAllActions(
            'woocommerce_simple_add_to_cart'
        );

        $this->adapter->addActionListener(
            'woocommerce_simple_add_to_cart',
            'onDisplayOnlyProductStockStatusAction'
        );
    } // end removeAddToCartButton
}
