<?php
namespace Victor\Trial\Model;

class Savedata extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    const CACHE_TAG = 'victor_trial_product';

    protected $_cacheTag = 'victor_trial_product';

    protected $_eventPrefix = 'victor_trial_product';

    protected function _construct()
    {
        $this->_init('\Victor\Trial\Model\ResourceModel\Data');
    }

    public function getIdentities()
    {
        return [
            self::CACHE_TAG . '_' . $this->getId()
        ];
    }

    public function getDefaultValues()
    {
        $values = [];
        
        return $values;
    }
}