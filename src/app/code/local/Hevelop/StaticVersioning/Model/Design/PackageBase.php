<?php
if (Mage::helper('core')->isModuleEnabled('Aoe_DesignFallback')
    && class_exists('Aoe_DesignFallback_Model_Design_Package')
) {
    class_alias('Aoe_DesignFallback_Model_Design_Package', 'Hevelop_StaticVersioning_Model_Design_PackageBase');
} else {
    class Hevelop_StaticVersioning_Model_Design_PackageBase extends Mage_Core_Model_Design_Package
    {
    }
}