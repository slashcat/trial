<?php
namespace Victor\Trial\Model\Config\Source;

class ListMode implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            [
                'value' => '* * * * *',
                'label' => __('Each minute')
            ],
            [
                'value' => '* */1 * * *',
                'label' => __('Hourly')
            ],
            [
                'value' => '* * */1 * *',
                'label' => __('Daily')
            ],
            [
                'value' => '* * * */1 *',
                'label' => __('Monthly')
            ]
        ];
    }

  
}
