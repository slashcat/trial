<?php
namespace Victor\Trial\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;





class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
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

    
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (! $installer->tableExists('victor_trial_products')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('victor_trial_products'))
                ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
            ], 'Post ID')
                ->addColumn('uuid', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Uuid')
                ->
            addColumn('property_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 5, [
                'nullable => false'
            ], 'Post Name')
                ->addColumn('county', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'County')
                ->addColumn('country', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k', [], 'Country')
                ->addColumn('town', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Town')
                ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Description')
                ->addColumn('address', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Address')
                ->addColumn('image_full', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Image')
                ->addColumn('image_thumbnail', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Image Thumbnail')
                ->addColumn('latitude', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Latitude')
                ->addColumn('longitude', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Longitude')
                ->addColumn('num_bedrooms', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 2, [], 'Number of Bedrooms')
                ->addColumn('num_bathrooms', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Number of Bathrooms')
                ->addColumn('price', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, [], 'Price')
                ->addColumn('type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Type')
                ->addColumn('property_type', \Magento\Framework\DB\Ddl\Table::TYPE_BLOB, 65535, [], 'Property Type')
                ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ], 'Created At')
                ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ], 'Updated At')
                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);

        }
        
        $setup->startSetup();

        
        
    }
        
}
