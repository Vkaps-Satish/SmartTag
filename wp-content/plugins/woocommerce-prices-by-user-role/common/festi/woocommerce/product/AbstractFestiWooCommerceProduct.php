<?php

class AbstractFestiWooCommerceProduct
{
    protected $adapter;
    protected $productMinimalQuantity = 1;
    protected $minimalPricesCount = 1;
    protected $ecommerceFacade;
    protected $wordpressFacade;
    
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
        $this->ecommerceFacade = EcommerceFactory::getInstance();
        $this->wordpressFacade = WordpressFacade::getInstance();
    } // end __construct
    
    public function onInit()
    {
    } //end onInit
    
    public function getMaxProductPice($product, $display)
    {
        throw new Exception("Undefined methode getMaxProductPice");
    } // end getMaxProductPice
    
    public function getMinProductPice($product, $display)
    {
        throw new Exception("Undefined methode getMinProductPice");
    } // end getMinProductPice
    
    public function getPriceRange($product)
    {
        return false;
    } // end getPriceRange

    public function getChildren($product)
    {
        $facade = $this->ecommerceFacade;

        return $facade->getVariationChildrenIDs($product);
    } // end getChildren
    
    public function getUserPrice($product, $display = false)
    {
        if (!$display) {
            return $product->get_price();
        }

        $facade = $this->ecommerceFacade;

        if ($facade->isDisplayPricesIncludeTax()) {
            return $facade->getPriceIncludingTax($product);
        }

        return $facade->getPriceExcludingTax($product);
    } // end getUserPrice

    public function getRegularPrice($product, $display)
    {
        $price = $product->get_regular_price();
        
        if (!$display) {
            return $price;
        }
        
        $quantity = $this->productMinimalQuantity;
        
        $facade = &$this->ecommerceFacade;
        
        $options = array(
            'qty'   => $quantity,
            'price' => $price
        );
        
        if ($facade->isDisplayPricesIncludeTax()) {
            return $facade->getPriceIncludingTax($product, $options);
        }
        
        return $facade->getPriceExcludingTax($product, $options);
    } // end getRegularPrice
    
    public function isAvaliableToDisplaySaleRange($product)
    {
        throw new Exception("Undefined methode isAvaliableToDisplaySaleRange");
    }
    
    public function getFormatedPriceForSaleRange($product, $userPrice)
    {
        throw new Exception("Undefined methode getFormatedPriceForSaleRange");
    } // end getFormatedPriceForSaleRange
    
    public function getPriceSuffix($product, $price)
    {
        return $product->get_price_suffix($price);
    } // end getPriceSuffix
}