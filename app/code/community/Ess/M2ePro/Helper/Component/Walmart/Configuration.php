<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

class Ess_M2ePro_Helper_Component_Walmart_Configuration extends Mage_Core_Helper_Abstract
{
    const SKU_MODE_DEFAULT          = 1;
    const SKU_MODE_CUSTOM_ATTRIBUTE = 2;
    const SKU_MODE_PRODUCT_ID       = 3;

    const SKU_MODIFICATION_MODE_NONE     = 0;
    const SKU_MODIFICATION_MODE_PREFIX   = 1;
    const SKU_MODIFICATION_MODE_POSTFIX  = 2;
    const SKU_MODIFICATION_MODE_TEMPLATE = 3;

    const GENERATE_SKU_MODE_NO  = 0;
    const GENERATE_SKU_MODE_YES = 1;

    const UPC_MODE_NOT_SET          = 0;
    const UPC_MODE_CUSTOM_ATTRIBUTE = 1;

    const EAN_MODE_NOT_SET          = 0;
    const EAN_MODE_CUSTOM_ATTRIBUTE = 1;

    const GTIN_MODE_NOT_SET          = 0;
    const GTIN_MODE_CUSTOM_ATTRIBUTE = 1;

    const ISBN_MODE_NOT_SET          = 0;
    const ISBN_MODE_CUSTOM_ATTRIBUTE = 1;

    const CONFIG_GROUP = '/walmart/configuration/';

    //########################################

    public function setSkuMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'sku_mode', $mode);
    }

    public function getSkuMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'sku_mode');
    }

    public function isSkuModeDefault()
    {
        return $this->getSkuMode() == self::SKU_MODE_DEFAULT;
    }

    public function isSkuModeCustomAttribute()
    {
        return $this->getSkuMode() == self::SKU_MODE_CUSTOM_ATTRIBUTE;
    }

    public function isSkuModeProductId()
    {
        return $this->getSkuMode() == self::SKU_MODE_PRODUCT_ID;
    }

    // ---------------------------------------

    public function setSkuCustomAttribute($attribute)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'sku_custom_attribute', $attribute
        );
    }

    public function getSkuCustomAttribute()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'sku_custom_attribute');
    }

    // ---------------------------------------

    public function setSkuModificationMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'sku_modification_mode', $mode);
    }

    public function getSkuModificationMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(
            self::CONFIG_GROUP, 'sku_modification_mode'
        );
    }

    public function isSkuModificationModeNone()
    {
        return $this->getSkuModificationMode() == self::SKU_MODIFICATION_MODE_NONE;
    }

    public function isSkuModificationModePrefix()
    {
        return $this->getSkuModificationMode() == self::SKU_MODIFICATION_MODE_PREFIX;
    }

    public function isSkuModificationModePostfix()
    {
        return $this->getSkuModificationMode() == self::SKU_MODIFICATION_MODE_POSTFIX;
    }

    public function isSkuModificationModeTemplate()
    {
        return $this->getSkuModificationMode() == self::SKU_MODIFICATION_MODE_TEMPLATE;
    }

    // ---------------------------------------

    public function setSkuModificationCustomValue($value)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'sku_modification_custom_value', $value
        );
    }

    public function getSkuModificationCustomValue()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(
            self::CONFIG_GROUP, 'sku_modification_custom_value'
        );
    }

    // ---------------------------------------

    public function setGenerateSkuMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'generate_sku_mode', $mode);
    }

    public function getGenerateSkuMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'generate_sku_mode');
    }

    public function isGenerateSkuModeNo()
    {
        return $this->getGenerateSkuMode() == self::GENERATE_SKU_MODE_NO;
    }

    public function isGenerateSkuModeYes()
    {
        return $this->getGenerateSkuMode() == self::GENERATE_SKU_MODE_YES;
    }

    //########################################

    public function setUpcMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'upc_mode', $mode);
    }

    public function getUpcMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'upc_mode');
    }

    public function isUpcModeNotSet()
    {
        return $this->getUpcMode() == self::UPC_MODE_NOT_SET;
    }

    public function isUpcModeCustomAttribute()
    {
        return $this->getUpcMode() == self::UPC_MODE_CUSTOM_ATTRIBUTE;
    }

    // ---------------------------------------

    public function setUpcCustomAttribute($attribute)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'upc_custom_attribute', $attribute
        );
    }

    public function getUpcCustomAttribute()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(
            self::CONFIG_GROUP, 'upc_custom_attribute'
        );
    }

    //########################################

    public function setEanMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'ean_mode', $mode);
    }

    public function getEanMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'ean_mode');
    }

    public function isEanModeNotSet()
    {
        return $this->getEanMode() == self::EAN_MODE_NOT_SET;
    }

    public function isEanModeCustomAttribute()
    {
        return $this->getEanMode() == self::EAN_MODE_CUSTOM_ATTRIBUTE;
    }

    // ---------------------------------------

    public function setEanCustomAttribute($attribute)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'ean_custom_attribute', $attribute
        );
    }

    public function getEanCustomAttribute()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'ean_custom_attribute');
    }

    //########################################

    public function setGtinMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'gtin_mode', $mode);
    }

    public function getGtinMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'gtin_mode');
    }

    public function isGtinModeNotSet()
    {
        return $this->getGtinMode() == self::GTIN_MODE_NOT_SET;
    }

    public function isGtinModeCustomAttribute()
    {
        return $this->getGtinMode() == self::GTIN_MODE_CUSTOM_ATTRIBUTE;
    }

    // ---------------------------------------

    public function setGtinCustomAttribute($attribute)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'gtin_custom_attribute', $attribute
        );
    }

    public function getGtinCustomAttribute()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'gtin_custom_attribute');
    }

    //########################################

    public function setIsbnMode($mode)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(self::CONFIG_GROUP, 'isbn_mode', $mode);
    }

    public function getIsbnMode()
    {
        return (int)Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'isbn_mode');
    }

    public function isIsbnModeNotSet()
    {
        return $this->getIsbnMode() == self::ISBN_MODE_NOT_SET;
    }

    public function isIsbnModeCustomAttribute()
    {
        return $this->getIsbnMode() == self::ISBN_MODE_CUSTOM_ATTRIBUTE;
    }

    // ---------------------------------------

    public function setIsbnCustomAttribute($attribute)
    {
        Mage::helper('M2ePro/Module')->getConfig()->setGroupValue(
            self::CONFIG_GROUP, 'isbn_custom_attribute', $attribute
        );
    }

    public function getIsbnCustomAttribute()
    {
        return Mage::helper('M2ePro/Module')->getConfig()->getGroupValue(self::CONFIG_GROUP, 'isbn_custom_attribute');
    }

    //########################################

    public function getConfigValues()
    {
        return array(
            'sku_mode'                      => $this->getSkuMode(),
            'sku_custom_attribute'          => $this->getSkuCustomAttribute(),
            'sku_modification_mode'         => $this->getSkuModificationMode(),
            'sku_modification_custom_value' => $this->getSkuModificationCustomValue(),
            'generate_sku_mode'             => $this->getGenerateSkuMode(),
            'upc_mode'                      => $this->getUpcMode(),
            'upc_custom_attribute'          => $this->getUpcCustomAttribute(),
            'ean_mode'                      => $this->getEanMode(),
            'ean_custom_attribute'          => $this->getEanCustomAttribute(),
            'gtin_mode'                     => $this->getGtinMode(),
            'gtin_custom_attribute'         => $this->getGtinCustomAttribute(),
            'isbn_mode'                     => $this->getIsbnMode(),
            'isbn_custom_attribute'         => $this->getIsbnCustomAttribute(),
        );
    }

    public function setConfigValues(array $values)
    {
        if (isset($values['sku_mode'])) {
            $this->setSkuMode($values['sku_mode']);
        }

        if (isset($values['sku_custom_attribute'])) {
            $this->setSkuCustomAttribute($values['sku_custom_attribute']);
        }

        if (isset($values['sku_modification_mode'])) {
            $this->setSkuModificationMode($values['sku_modification_mode']);
        }

        if (isset($values['sku_modification_custom_value'])) {
            $this->setSkuModificationCustomValue($values['sku_modification_custom_value']);
        }

        if (isset($values['generate_sku_mode'])) {
            $this->setGenerateSkuMode($values['generate_sku_mode']);
        }

        if (isset($values['upc_mode'])) {
            $this->setUpcMode($values['upc_mode']);
        }

        if (isset($values['upc_custom_attribute'])) {
            $this->setUpcCustomAttribute($values['upc_custom_attribute']);
        }

        if (isset($values['ean_mode'])) {
            $this->setEanMode($values['ean_mode']);
        }

        if (isset($values['ean_custom_attribute'])) {
            $this->setEanCustomAttribute($values['ean_custom_attribute']);
        }

        if (isset($values['gtin_mode'])) {
            $this->setGtinMode($values['gtin_mode']);
        }

        if (isset($values['gtin_custom_attribute'])) {
            $this->setGtinCustomAttribute($values['gtin_custom_attribute']);
        }

        if (isset($values['isbn_mode'])) {
            $this->setIsbnMode($values['isbn_mode']);
        }

        if (isset($values['isbn_custom_attribute'])) {
            $this->setIsbnCustomAttribute($values['isbn_custom_attribute']);
        }
    }

    //########################################
}