<?php
namespace Cent\RefrigeratorBundle\Extension\Adapter;

use Cent\RefrigeratorBundle\Entity\CacheDataEntity;
/**
 * RedisAdapter
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class RedisAdapter extends AbstarctCacheAdapter
{
    /**
     * @return boolean
     */
    public function isActive()
    {
        if (!$this->getClient()->isConnected()) {
            $this->getClient()->connect();
        }
        
        return $this->getClient()->isConnected();
    }
    
    /**
     * Set cache data
     * 
     * @param string $key
     * @param \Cent\RefrigeratorBundle\Entity\CacheDataEntity $cacheDataEntity
     * @param array $options
     */
    public function setCacheData($key, CacheDataEntity $cacheDataEntity, $options = array())
    {
        $client = $this->getClient();
        $client->set($key, (string) $cacheDataEntity);
        if (isset($options['expire'])) {
            $client->expire($key, $options['expire']);
        }
        
        return $this;
    }
    
    /**
     * @param string $key
     * @return \Cent\RefrigeratorBundle\Entity\CacheDataEntity
     */
    public function getCacheData($key)
    {
        if ( null != ($data = $this->getClient()->get($key))) {
            $data = new CacheDataEntity($data);
        }
        
        return $data;
    }
}
