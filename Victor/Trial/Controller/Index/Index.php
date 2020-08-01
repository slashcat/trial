<?php
namespace Victor\Trial\Controller\Index;

use Magento\Framework\App\Action\Action;
use Victor\Trial\Model\SavedataFactory;
use Magento\Framework\App\Action\Context;
use Magento\Marketplace\Helper\Cache;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\HTTP\Client\Curl;

class Index extends Action
{

    protected $_moduleFactory;

    /**
     *
     * @var Curl
     */
    protected $curlClient;

    /**
     *
     * @var string
     */
    protected $urlPrefix = 'https://';

    /**
     *
     * @var string
     */
    protected $apiUrl = 'magento.com/magento-connect/platinumpartners/list';

    /**
     *
     * @var \Magento\Marketplace\Helper\Cache
     */
    protected $cache;

    protected $connection;

    protected $id_product;
    protected $_scopeConfig;

    /**
     * Define resource model
     */
    public function __construct(Curl $curl, Cache $cache, UrlInterface $backendUrl, Context $context, SavedataFactory $moduleFactory, \Magento\Framework\App\ResourceConnection $resource, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->curlClient = $curl;
        $this->cache = $cache;
        $this->backendUrl = $backendUrl;
        
        $this->_moduleFactory = $moduleFactory;
        $this->connection = $resource->getConnection();
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     *
     * @return string
     */
    public function getReferer()
    {
        return \Magento\Framework\App\Request\Http::getUrlNoScript($this->backendUrl->getBaseUrl()) . 'admin/marketplace/index/index';
    }

    /**
     *
     * @return cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     *
     * @return Curl
     */
    public function getCurlClient()
    {
        return $this->curlClient;
    }

    public function setproductId($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getproductId()
    {
        return $this->id_product;
    }

    /*
     * @author: Victor Albala
     * @date: 31/7/2020
     * @return boolean
     * @action: Compare each value, if it's different it will update
     */
    private function compare($data, $array_keys, $res)
    {
        $array = array();
        foreach ($array_keys as $keyvalue) {
            
            if ($res[$keyvalue] != $data[$keyvalue]) {
                return true;
            }
        }
        return false;
    }

    
    public function execute()
    {
        $url = $this->_scopeConfig->getValue(
            'victor_trial_settings_api_details/general/url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ); 
        $key = $this->_scopeConfig->getValue(
            'victor_trial_settings_api_details/general/key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ); 
        
        $status =  $this->_scopeConfig->getValue(
            'victor_trial_settings_api_details/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ); 
        
         
        
        if((!isset($key))||(!isset($url))||($status==0))
        {
            die("Complete the URL and enable the plugin to run this cron");
        }
        
        $apiUrl = $url."?api_key=".$key;
        
        try {
            $this->getCurlClient()->get($apiUrl, []);
            $this->getCurlClient()->setOptions([
                CURLOPT_REFERER => $this->getReferer()
            ]);
            $this->getCurlClient()->setOption(CURLOPT_RETURNTRANSFER, true);
            $response = json_decode($this->getCurlClient()->getBody(), true);
            
            // $model = $this->_moduleFactory->create();
            
            foreach ($response["data"] as $res) {
                
                $model = $this->_moduleFactory->create();
                
                $collection = $model->getCollection();
                
                $collection = $this->_moduleFactory->create()->getCollection();
                
                $collection->addFieldToFilter('uuid', $res['uuid']);
                
                $continue = false;
                
                if ($collection->getSize()) {
                    
                    $data = $collection->getFirstItem()->getData();
                    
                    $array_keys = array_keys($res);
                    
                    $this->setproductId($data["id"]);
                    $res["property_type"] = json_encode($res["property_type"]);
                    
                    $diff = $this->compare($data, $array_keys, $res); // We compare each field
                    if ($diff == true) {
                        $model->setId($this->getproductId());
                    } else {
                        $continue = true;
                    }
                }
                
                if ($continue == true) { //If product already exist we skip
                    continue;
                }
                
                $model->setUuid($res['uuid']);
                $model->setPropertyTypeId($res['property_type_id']);
                $model->setCounty($res['county']);
                $model->setCountry($res['country']);
                $model->setTown($res['town']);
                $model->setDescription($res['description']);
                $model->setAddress($res['address']);
                $model->setImageFull($res['image_full']);
                $model->setImageThumbnail($res['image_thumbnail']);
                $model->setLatitude($res['latitude']);
                $model->setLongitude($res['longitude']);
                $model->setNumBedrooms($res['num_bedrooms']);
                $model->setNumBathrooms($res['num_bathrooms']);
                $model->setPrice($res['price']);
                $model->setType($res['type']);
                $model->setPropertyType($res['property_type']);
                $model->setCreatedAt($res['created_at']);
                $model->setUpdatedAt($res['updated_at']);
                $model->save();
            }
            die("Finish");
        } catch (\Exception $e) {
            return $this->getCache()->loadPartnersFromCache();
        }
    }
}