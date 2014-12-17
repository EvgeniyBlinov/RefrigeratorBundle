<?php
namespace Cent\RefrigeratorBundle\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cent\RefrigeratorBundle\Extension\Adapter\RedisAdapter;
use Cent\RefrigeratorBundle\Extension\Adapter\AbstarctCacheAdapter;
use Cent\RefrigeratorBundle\Entity\CacheDataEntity;

use Cent\RefrigeratorBundle\Extension\RefrigeratorOptionsFactory;

/**
 * CacheFactory
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */
class CacheFactory 
{
    private $_adapter;
    private $_options = array();
    private $_tags = array();
    private $_cacheOptions = array();
    private $_cacheOptionsIgnored = array();
    
    protected $_cache;
    protected $_request;
    protected $_response;
    
    /**
     * Constructor
     * 
     * @param $cache
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param array $settings
     */
    public function __construct($cache, RequestStack $requestStack, $settings = array())
    {
        $this->_cache = $cache;
        $this->setRequest($requestStack->getCurrentRequest());
        $this->setSettings($settings);
    }
    
    /**
     * Set settings
     * 
     * @param array $settings
     * @return CacheFactory
     */
    public function setSettings(array $settings)
    {
        if (isset($settings['options']) && count($settings['options'])) {
            $this->_options = array_merge($this->getDefaultOptions(), $settings['options']);
        }
        
        if (isset($settings['options']) && count($settings['options'])) {
            $this->_options = array_merge($this->getDefaultOptions(), $settings['options']);
        }
        
        if (isset($settings['tags']) && count($settings['tags'])) {
            $this->_tags = $settings['tags'];
        }
        
        if (isset($settings['cache_options']) && ($settings['cache_options'] instanceof RefrigeratorOptionsFactory)) {
            $this->_cacheOptions = $settings['cache_options'];
        }
        
        if (isset($settings['cache_options_ignored']) && count($settings['cache_options_ignored'])) {
            $this->_cacheOptionsIgnored = $settings['cache_options_ignored'];
        }
        
        return $this;
    }
    
    /**
     * @return array of default options
     */
    public function getDefaultOptions()
    {
        return array(
            'cache_all' => false,
        );
    }
    
    /**
     * Get cache option
     * 
     * @param array $params
     * @return mixed
     */
    public function getCacheOption($params)
    {
        if (!empty($this->_cacheOptions)) {
            return $this->_cacheOptions->getOption($params);
        }
        
        return null;
    }
    
    /**
     * @return array of options
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
    /**
     * Get option
     * 
     * @param string $name
     * @return array of options
     */
    public function getOption($name)
    {
        return isset($this->_options[$name]) ? $this->_options[$name] : null;
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
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        
        return $this;
    }
    
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Set request
     * 
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Cent\RefrigeratorBundle\Extension\CacheFactory
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        
        return $this;
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function getKey(Request $request)
    {
        return $request->getPathInfo();
    }
    
    /**
     * Get cache data
     * 
     * @return \Cent\RefrigeratorBundle\Entity\CacheDataEntity
     */
    public function getCacheData()
    {
        return $this->getAdapter()->getCacheData($this->getKey($this->getRequest()));
    }
    
    /**
     * Set cache data
     */
    public function setCacheData()
    {
        
        // @TODO
        
        /*******************         @TODO      ****************************
         * !!!Механизм сброса по тегам
         * Доделать композер
         * Подправить формы
         * Удалить ненужные формы
         * сброс по тегам
         * придумать систему хранения
         * запись в кеш отдельных частей
         * сделать параметр игнорируемых страниц
         * Положить в редис по параметрам (ссылка лимит)
         * Понимать, что это ajax запрос
         * 
         * http://ska.dev.funcfunc.ru/championship/getTweets?hashtag=%23SKAAMR21214&last_tweet_id=539853022571270144
         * 
         * Разделение на ска и ска 1946
         * Сделать хранение тегов и ссылок к ним в БД
         * 
         * 
         */
         
         /**
         *                  @TODO
         * Записать хедеры и куки по отдельному в ключ
         * хранить хедеры и контент
         * хранить теги сущностей в редисе, для того, чтобы можно было
         * удалять ключи при обновлении какого-нибудь тега
         * выкидывать из хедеров куки, чтобы не было уязвимости
         *
         /**/
        //foreach ($this->headers->allPreserveCase() as $name => $values) {
            //foreach ($values as $value) {
                //header($name.': '.$value, false, $this->statusCode);
            //}
        //}

        //// cookies
        //foreach ($this->headers->getCookies() as $cookie) {
            //setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        //}
        //headers_list()
        
        $key = $this->getKey($this->getRequest());
        if (!$this->isIgnored($key)) {
            $cacheOptions = (array) $this->getCacheOption(array('name' => $key));
            if ($this->getOption('cache_all') || count($cacheOptions)) {
                $status = $this->getAdapter()->setCacheData(
                    $key,
                    new CacheDataEntity(array(
                        'meta'    => '',
                        'headers' => json_encode(headers_list()),
                        'content' => $this->getResponse()->getContent(),
                    )),
                    $cacheOptions
                );
            }
        }
        
        return $this;
    }
    
    /**
     * Is this name in ignored
     * 
     * @param string $name
     * @return boolean
     */
    public function isIgnored($name)
    {
        foreach ($this->_cacheOptionsIgnored as $ignored) {
            if (isset($ignored['pattern']) && preg_match($ignored['pattern'], $name)) {
                return true;
            }
            
            if (isset($ignored['name']) && $ignored['name'] == $name) {
                return true;
            }
        }
        
        return false;
    }
}
