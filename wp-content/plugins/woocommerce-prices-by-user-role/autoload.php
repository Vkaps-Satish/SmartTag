<?php

if (!class_exists('SettingsWooUserRolePrices')) {
    require_once dirname(__FILE__).'/SettingsWooUserRolePrices.php';
}

if (!class_exists("CsvWooProductsImporter")) {
    $fileName = 'CsvWooProductsImporter.php';
    require_once dirname(__FILE__).'/common/import/'.$fileName;
}

if (!class_exists("ImportWooProductException")) {
    $fileName = 'ImportWooProductException.php';
    require_once dirname(__FILE__).'/common/import/'.$fileName;
}

if (!class_exists("FestiTeamApiClient")) {
    $fileName = 'FestiTeamApiClient.php';
    require_once dirname(__FILE__).'/common/api/'.$fileName;
}

if (!class_exists("AbstractWooUserRolePricesBackendTab")) {
    $fileName = 'AbstractWooUserRolePricesBackendTab.php';
    require_once __DIR__.'/common/backend/tabs/'.$fileName;
}

if (!class_exists("WooUserRolePricesSettingsBackendTab")) {
    $fileName = 'WooUserRolePricesSettingsBackendTab.php';
    require_once __DIR__.'/common/backend/tabs/'.$fileName;
}

if (!class_exists("WooUserRolePricesHidingRulesBackendTab")) {
    $fileName = 'WooUserRolePricesHidingRulesBackendTab.php';
    require_once __DIR__.'/common/backend/tabs/'.$fileName;
}

if (!class_exists("WooUserRolePricesTaxOptionsBackendTab")) {
    $fileName = 'WooUserRolePricesTaxOptionsBackendTab.php';
    require_once __DIR__.'/common/backend/tabs/'.$fileName;
}

if (!class_exists("CsvWooProductsExporter")) {
    $fileName = 'CsvWooProductsExporter.php';
    require_once __DIR__.'/common/export/'.$fileName;
}