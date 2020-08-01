<?php
namespace Victor\Trial\Model\ResourceModel\Data;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'post_id';

    protected $_eventPrefix = 'victor_trial_product_collection';

    protected $_eventObject = 'product_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Victor\Trial\Model\Savedata', 'Victor\Trial\Model\ResourceModel\Data');
    }
}