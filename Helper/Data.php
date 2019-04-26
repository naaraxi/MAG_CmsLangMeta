<?php
/**
 * A Magento 2 module named MAG/CmsLangMeta
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */

namespace MAG\CmsLangMeta\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */
class Data extends AbstractHelper
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

    /*
     * Config lines
     */
    public $_configLines;

    /**
     * Constructor
     *
     * @param Context                                            $context      Context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig  Scope config
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager Store manager
     * @param array                                              $data         Data
     *
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;

        $this->_configLines = $this->fetchConfigLines();

        parent::__construct($context);
    }

    /**
     * Return configLines
     *
     * @return array
     */
    public function getConfigLines()
    {
        return $this->_configLines;
    }

    /**
     * Get language association config lines
     *
     * @return array
     */
    public function fetchConfigLines()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $lang_assoc = $this->scopeConfig->getValue(self::XML_PATH_LANG_ASSOC, $storeScope, $this->getStoreId());
        $lines = (strlen($lang_assoc)) ? json_decode($lang_assoc, true) : array();
        return $lines;
    }

    /**
     * Get store identifier
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_MODULE_ACTIVE, $storeScope, $this->getStoreId());
    }
}

