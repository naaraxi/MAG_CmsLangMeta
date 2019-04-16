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

namespace MAG\CmsLangMeta\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class LanguageAssociation
 *
 * @category Magento_2
 * @package  MAG_CmsLangMeta
 * @author   Alex M <no@public.email>
 * @license  osl-3.0 http://opensource.org/licenses/osl-3.0.php
 * @link     https://github.com/naaraxi/MAG_CmsLangMeta
 */
class LanguageAssociation extends ConfigValue
{
    /**
     * Json Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * ShippingMethods constructor
     *
     * @param SerializerInterface   $serializer         Serializer
     * @param Context               $context            Context
     * @param Registry              $registry           Registry
     * @param ScopeConfigInterface  $config             Config
     * @param TypeListInterface     $cacheTypeList      Cache
     * @param AbstractResource|null $resource           Resource
     * @param AbstractDb|null       $resourceCollection ResourceCollection
     * @param array                 $data               Data
     */
    public function __construct(
        SerializerInterface $serializer,
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->serializer = $serializer;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Prepare data before save
     *
     * @return void
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        unset($value['__empty']);
        $encodedValue = $this->serializer->serialize($value);

        $this->setValue($encodedValue);
    }

    /**
     * Process data after load
     *
     * @return void
     */
    protected function _afterLoad()
    {
        $value = $this->getValue();
        $decodedValue = (strlen($value)) ? $this->serializer->unserialize($value) : array();

        $this->setValue($decodedValue);
    }
}
