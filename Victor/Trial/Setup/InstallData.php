<?php
namespace Victor\Trial\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     *
     * {@inheritdoc} @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create([
            'setup' => $setup
        ]);
        /**
         * Add attributes to the eav/attribute
         */
        
        $array_attributes = array(
            array('value'=>'county','label'=>'County'),
            array('value'=>'country','label'=>'Country'),
            array('value'=>'town','label'=>'Town'),
            array('value'=>'descriptions','label'=>'Descriptions'),
            array('value'=>'displayable_address','label'=>'Displayable Address'),
            array('value'=>'image_url','label'=>'Image URL'),
            array('value'=>'thumbnail_url','label'=>'Thumbnail URL'),
            array('value'=>'number_of_bedrooms','label'=>'Number of Bedrooms'),
            array('value'=>'number_of_bathrooms','label'=>'Number of Bathrooms'),
            array('value'=>'price','label'=>'Price'),
            array('value'=>'property_type','label'=>'Property Type'),
            array('value'=>'for_sale_rent','label'=>'For Sale / Rent')  
        );
 
        
        foreach ($array_attributes as $attribute) {
      //      var_dump($attribute["value"]);die();
            $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, $attribute["value"], [
                'type' => 'varchar',
                'backend' => '',
                'frontend' => '',
                'label' => $attribute["label"],
                'input' => '',
                'class' => '',
                'source' => 'victor_trial',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => 0,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]);
        }
        
        $installer = $setup;
        

    }
}