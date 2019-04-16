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

        parent::__construct($context);
    }

    /**
     * Get language config for current store
     *
     * @return string/bool
     */
    public function _getConfigForCurrentStore()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $lang_assoc = $this->scopeConfig->getValue(self::XML_PATH_LANG_ASSOC, $storeScope, $this->getStoreId());
        $lines = (strlen($lang_assoc)) ? json_decode($lang_assoc, true) : array();
        foreach ($lines as $config) {
            if ($config['storeid'] == $this->getStoreId()) {
                // Config found for current store view
                return $config['language'];
            }
        }

        // No config for current store view
        return false;
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

