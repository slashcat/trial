<?php
 
namespace Victor\Trial\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Button extends Field
{

    protected $_template = 'Victor_Trial::system/config/button.phtml';

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function render(AbstractElement $element)
    {
        $element->unsScope()
            ->unsCanUseWebsiteValue()
            ->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    public function getCustomUrl()
    {
        return $this->getUrl('router/controller/action');
    }

    public function getButtonHtml()
    {
        $button = $this->getLayout()
            ->createBlock('Magento\Backend\Block\Widget\Button')
            ->setData([
            'id' => 'victor_trial_button_sync_data',
            'label' => __('Sync data'),
                'onclick'=>"location.href='".$this->getCustomUrl()."'",
        ]);
        return $button->toHtml();
    }
}