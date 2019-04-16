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

namespace MAG\CmsLangMeta\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class LanguageAssociation
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */
class LanguageAssociation extends AbstractFieldArray
{
    /*
     * Store IDs
     */
    private $_storeIds;

    /**
     * Get store ID's
     *
     * @return \MAG\CmsLangMeta\Block\Adminhtml\Form\Field\StoreId
     */
    protected function _getStoreIdRenderer()
    {
        if (!$this->_storeIds) {
            $this->_storeIds = $this->getLayout()->createBlock(
                '\MAG\CmsLangMeta\Block\Adminhtml\Form\Field\Renderer\StoreView',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->_storeIds;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('storeid', ['label' => __('Store View ID'), 'renderer' => $this->_getStoreIdRenderer()]);
        $this->addColumn('language', ['label' => __('Language Code'), 'class' => 'required-entry', 'size' => '5']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Language Association');
    }

    /**
     * Prepare existing row data object.
     *
     * @param \Magento\Framework\DataObject $row Row
     *
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];
        $customAttribute = $row->getData('storeid');

        $key = 'option_' . $this->_getStoreIdRenderer()->calcOptionHash($customAttribute);
        $options[$key] = 'selected="selected"';
        $row->setData('option_extra_attrs', $options);
    }
}
