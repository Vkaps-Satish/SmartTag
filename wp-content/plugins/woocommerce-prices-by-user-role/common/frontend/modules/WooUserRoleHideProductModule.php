<?php
    
class WooUserRoleHideProductModule extends AbstractWooUserRoleModule
{
    public function onHideProductByUserRole($query)
    {
        $facade = EcommerceFactory::getInstance();

        if (!$facade->isProductPost($query)) {
            return false;
        }

        $frontend = $this->frontend;

        $userRole = $frontend->userRole;

        if ($frontend->hasHideAllProductsOptionInSettings()) {
            $this->_setPrepareQueryForSearchVisibleProducts(
                $userRole,
                $query
            );
        } else {
            $this->_setPrepareQueryWithoutHiddenAllProductsOption(
                $frontend,
                $userRole,
                $query
            );
        }
    } // end onHideProductByUserRole
    
    private function _hasHideProductByUserRole($userRole, $hideProducts)
    {
        return !is_admin() &&
                $userRole && 
                array_key_exists($userRole, $hideProducts) &&
                $hideProducts[$userRole];
    } // end _hasHideProductByUserRole
    
    private function _hasHideProductByGuestUser($userRole, $hideProducts)
    {
        return !is_admin() &&
               !$userRole && 
               $hideProducts;
    } // end _hasHideProductByGuestUser

    private function _getProductIDsForGuestUser($hideProducts)
    {
        $productIDs = array();

        foreach ($hideProducts as $key => $value) {

            if (empty($value)) {
                continue;
            }

            $productIDs = array_merge($value, $productIDs);
        }
        
        return array_unique($productIDs);
    } // end _getProductIDsForGuestUser

    private function _setPrepareQueryForSearchVisibleProducts(
        $userRole,
        $query
    )
    {
        if (!$userRole) {
            $userRole = 'guestUser';
        }

        $userRole = base64_encode($userRole);

        $metaKey = PRICE_BY_ROLE_IGNORE_HIDE_ALL_PRODUCT_OPTION_META_KEY;

        $query->set('meta_key', $metaKey);

        $query->set(
            'meta_query',
            array(
                'key'     => $metaKey,
                'value'   => $userRole,
                'compare' => 'LIKE'
            )
        );
    } // end _setPrepareQueryForSearchVisibleProducts

    private function _setPrepareQueryWithoutHiddenAllProductsOption(
        $frontend,
        $userRole,
        $query
    )
    {
        $hideProducts = $frontend->getOptions(
            PRICE_BY_ROLE_HIDDEN_PRODUCT_OPTIONS
        );

        if (!$hideProducts) {
            $hideProducts = array();
        }

        $productIDs = array();

        if ($this->_hasHideProductByGuestUser($userRole, $hideProducts)) {
            $productIDs = $this->_getProductIDsForGuestUser($hideProducts);
        }

        if ($this->_hasHideProductByUserRole($userRole, $hideProducts)) {
            $productIDs = $hideProducts[$userRole];
        }

        if ($productIDs) {
            $query->set('post__not_in', $productIDs);
        }
    } // end _setPrepareQueryWithoutHiddenAllProductsOption
}