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

    /*
     * Store manager
     */
    public $storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context      Context
     * @param \Magento\Store\Model\StoreManagerInterface       $storeManager Store manager
     * @param \MAG\CmsLangMeta\Helper\Data                     $helper       Helper
     * @param \Magento\Cms\Model\Page                          $page         CMS Page
     * @param array                                            $data         Data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MAG\CmsLangMeta\Helper\Data $helper,
        \Magento\Cms\Model\Page $page,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->page = $page;
        $this->storeManager = $storeManager;
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
        return ($this->isCmsPageShared() && !empty($this->helper->fetchConfigLines()));
    }

    /**
     * Get meta tags
     *
     * @return string
     */
    public function getMetaData()
    {
        $return = array();
        $data = $this->helper->fetchConfigLines();
        foreach ($data as $row) {
            $return[] = array(
                'language' => $row['language'],
                'url'      => $this->storeManager->getStore($row['storeid'])->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true])
            );
        }
        return $return;
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
