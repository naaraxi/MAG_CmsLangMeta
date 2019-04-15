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

namespace MAG\CmsLangMeta\Block\Html\Head;

/**
 * Meta block
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */
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

    /*
     * Page
     */
    public $page;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context   $context      Context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig  Scope config
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager Store manager
     * @param \Magento\Cms\Model\Page                            $page         CMS Page
     * @param array                                              $data         Data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Page $page,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->page = $page;
        parent::__construct($context, $data);
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

    /**
     * Check if there's a setting for current CMS page
     *
     * @return bool
     */
    public function hasLangSetting()
    {
        return ($this->isCmsPageShared() && $this->_getConfigForCurrentStore() !== false);
    }

    /**
     * Get CMS page URL
     *
     * @return string
     */
    public function getCmsUrl()
    {
        // This just gets the current URL, but since it only shows up on CMS pages
        // it should be more than adequate
        return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
    }

    /**
     * Get language code
     *
     * @return string
     */
    public function getCmsLang()
    {
        return $this->_getConfigForCurrentStore();
    }

    /**
     * Get store identifier
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Returns true if CMS page is associated to multiple store views
     *
     * @return bool
     */
    public function isCmsPageShared()
    {
        $storeIds = $this->page->getData('store_id');
        return (count($storeIds) > 1);
    }

    /**
     * Get language config for current store
     *
     * @return string/bool
     */
    private function _getConfigForCurrentStore()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $lang_assoc = $this->scopeConfig->getValue(self::XML_PATH_LANG_ASSOC, $storeScope, $this->getStoreId());
        $lines = explode("\n", $lang_assoc);
        foreach ($lines as $config) {
            $assoc = str_getcsv($config);
            if ($assoc[0] == $this->getStoreId()) {
                // Config found for current store view
                return $assoc[1];
            }
        }

        // No config for current store view
        return false;
    }
}
