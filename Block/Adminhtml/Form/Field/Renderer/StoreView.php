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

namespace MAG\CmsLangMeta\Block\Adminhtml\Form\Field\Renderer;

/**
 * Class StoreView
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */

class StoreView extends \Magento\Framework\View\Element\Html\Select
{
    /*
     * Store Ids
     */
    protected $storeManager;

    /*
     * Website collection
     */
    protected $websiteCollectionFactory;

    /*
     * Helper
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param Context               $context                  Context
     * @param StoreManagerInterface $storeManager             Store Manager
     * @param CollectionFactory     $websiteCollectionFactory Website collection factory
     * @param Data                  $helper                   Helper
     * @param array                 $data                     Data
     *
     * @return void
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\ResourceModel\Website\CollectionFactory $websiteCollectionFactory,
        \MAG\CmsLangMeta\Helper\Data $helper,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->websiteCollectionFactory = $websiteCollectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Set input name
     *
     * @param string $value Value
     *
     * @return Magently\Tutorial\Block\Adminhtml\Form\Field\Activation
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Parse to html.
     *
     * @return mixed
     */
    public function _toHtml()
    {
        $this->setClass('required-entry validate-select');
        if (!$this->getOptions()) {
            $stores = $this->storeManager->getStores();
            $this->addOption('', '');

            $lines = $this->helper->getConfigLines();

            foreach ($stores as $key => $store) {
                $this->addOption($key, $store->getWebsite()->getName() . ' - ' . $store['name']);
            }
        }

        return parent::_toHtml();
    }
}
