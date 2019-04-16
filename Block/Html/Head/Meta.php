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
    /*
     * Page
     */
    public $page;

    /*
     * Helper
     */
    public $helper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context Context
     * @param \MAG\CmsLangMeta\Helper\Data                     $helper  Helper
     * @param \Magento\Cms\Model\Page                          $page    CMS Page
     * @param array                                            $data    Data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MAG\CmsLangMeta\Helper\Data $helper,
        \Magento\Cms\Model\Page $page,
        array $data = []
    ) {
        $this->helper = $helper;
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
        return $this->helper->isModuleEnabled();
    }

    /**
     * Check if there's a setting for current CMS page
     *
     * @return bool
     */
    public function hasLangSetting()
    {
        return ($this->isCmsPageShared() && $this->helper->_getConfigForCurrentStore() !== false);
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
        return $this->helper->_getConfigForCurrentStore();
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
}
