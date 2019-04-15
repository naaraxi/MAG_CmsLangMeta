<?php
/**
 * A Magento 2 module named MAG/CmsLangMeta
 * Copyright (C) 2019 
 * 
 * This file included in MAG/CmsLangMeta is licensed under OSL 3.0
 * 
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace MAG\CmsLangMeta\Block\Html\Head;

class Meta extends \Magento\Framework\View\Element\Template
{
    const XML_PATH_MODULE_ACTIVE = 'cms/mag/active';
    const XML_PATH_LANG_ASSOC = 'cms/mag/language_association';
    /*
     * Scope config
     */
    public $scopeConfig;

    /*
     * Store manager
     */
    public $storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /*
     * Check if module is enabled
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_MODULE_ACTIVE, $storeScope);
    }

    /*
     * Check if there's a setting for current CMS page
     *
     * @return bool
     */
    public function hasLangSetting()
    {
        return true;
    }

    /*
     * Get CMS page URL
     *
     * @return string
     */
    public function getCmsUrl()
    {
        return 'URL';
    }

    /*
     * Get language code
     *
     * @return string
     */
    public function getCmsLang()
    {
        return 'LANG';
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
}
