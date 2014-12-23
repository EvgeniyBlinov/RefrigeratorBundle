<?php
namespace Cent\RefrigeratorBundle\Extension\Adapter;

use Cent\RefrigeratorBundle\Entity\CacheDataEntity;

/**
 * AbstarctCacheAdapter
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

abstract class AbstarctCacheAdapter 
{
    /**
     * @var mixed
     */
    protected $_client;
    
    /**
     * Constructor
     * 
     * @param mixed $client
     */
    public function __construct($client)
    {    
        $this->_client       = $client;
    }
    
    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->_client;
    }
    
    /**
     * @return boolean
     */
    abstract public function isActive();
    
    /**
     * Set cache data
     * 
     * @param string $key
     * @param \Cent\RefrigeratorBundle\Entity\CacheDataEntity $cacheDataEntity
     */
    abstract public function setCacheData($key, CacheDataEntity $cacheDataEntity, $options = array());
    
    /**
     * @param string $key
     * @return \Cent\RefrigeratorBundle\Entity\CacheDataEntity
     */
    abstract public function getCacheData($key);
}
