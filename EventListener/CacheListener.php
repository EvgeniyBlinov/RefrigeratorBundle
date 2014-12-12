<?php
namespace Cent\RefrigeratorBundle\EventListener;

use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent; 
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpFoundation\Request;

use Cent\RefrigeratorBundle\Entity\CacheDataEntity;

/**
 * CacheListener
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class CacheListener 
{
    /**
     * @var \Symfony\Component\DependencyInjection\IntrospectableContainerInterface
     */
    private $_container;
    /**
     * @var \Cent\RefrigeratorBundle\Extension\Adapter\AbstarctCacheAdapter
     */
    private $_cacheAdapter;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\DependencyInjection\IntrospectableContainerInterface $container
     * @param \Cent\RefrigeratorBundle\Extension\CacheFactory $cacheFactory
     */
    public function __construct(IntrospectableContainerInterface $container, $cacheFactory)
    {
        $this->_container = $container;
        $this->_cacheAdapter = $cacheFactory->getAdapter();
    }
    
    /**
     * onKernelController
     * 
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        
        if (
            $this->_container->getParameter('use_refrigerator_cache') &&
            is_array($controller) &&            // not a object but a different kind of callable. Do nothing
            $this->_cacheAdapter->isActive()
        ) {
            $controllerObject = $controller[0];

            if (false === strpos(get_class($controllerObject), 'Symfony\\Bundle')) {
                    
                if (null == $data = $this->_cacheAdapter->getCacheData($this->getKey($event->getRequest()))) {
                    return;
                }
                
                foreach ($data->getHeaders() as $header) {
                    header($header);
                }
                
                die($data->getAttribute('content'));
            }
        }
        
        return;
    }
    
    /**
     * onKernelResponse
     * 
     * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
     * @return void
     */
    public function onKernelResponse(PostResponseEvent $event)
    {
        if ($this->_container->getParameter('use_refrigerator_cache')) {
            $request = $event->getRequest();
            $response = $event->getResponse();
            
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
            
            $this->_cacheAdapter->setCacheData($this->getKey($event->getRequest()), new CacheDataEntity(array(
                'meta'    => '',
                'headers' => json_encode(headers_list()),
                'content' => $response->getContent(),
            )));
        }
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function getKey(Request $request)
    {
        //return sprintf('root%s', str_replace('/', ':', $request->getPathInfo()));
        return $request->getPathInfo();
    }
    
    
}
