<?php
namespace Cent\RefrigeratorBundle\Extension;

use Symfony\Component\HttpFoundation\RequestStack;

use Cent\RefrigeratorBundle\Extension\Adapter\RedisAdapter;
use Cent\RefrigeratorBundle\Extension\Adapter\AbstarctCacheAdapter;

/**
 * CacheFactory
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class CacheFactory 
{
    private $_adapter;
    
    protected $_cache;
    protected $_request;
    
    /**
     * Constructor
     * 
     * @param $cache
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    public function __construct($cache, RequestStack $requestStack)
    {
        $this->_cache = $cache;
        $this->setRequest($requestStack->getCurrentRequest());
    }
    
    /**
     * Get adapter
     * 
     * @return \Cent\RefrigeratorBundle\Extension\Adapter\AbstarctCacheAdapter
     */
    public function getAdapter()
    {
        if ($this->_adapter == null) {
            if ($this->_cache instanceof \Predis\Client) {
                $this->_adapter = new RedisAdapter($this->_cache);
            } else {
                throw new \Exception('Error: cache client not found!');
            }
        }

        return $this->_adapter;
    }
    
    /**
     * Set adapter
     * 
     * @param \Cent\RefrigeratorBundle\Extension\Adapter\AbstarctCacheAdapter $adapter
     * @return \Cent\RefrigeratorBundle\Extension\CacheFactory
     */
    public function setAdapter(AbstarctCacheAdapter $adapter)
    {
        $this->_adapter = $adapter;
        
        return $this;
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    /**
     * Set request
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Cent\RefrigeratorBundle\Extension\CacheFactory
     */
    public function setRequest(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->_request = $request;
        
        return $this;
    }
    
    /**
    public function getCache()
    {
        return $this->_cache;
    }
    
    public function setCache($cache)
    {
        $this->_cache = $cache;
        
        return $this;
    }
    /**/
    
    
}
