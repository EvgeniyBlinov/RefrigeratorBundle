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
     * @var \Cent\RefrigeratorBundle\Extension\CacheFactory
     */
    private $_cacheFactory;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\DependencyInjection\IntrospectableContainerInterface $container
     * @param \Cent\RefrigeratorBundle\Extension\CacheFactory $cacheFactory
     */
    public function __construct(IntrospectableContainerInterface $container, $cacheFactory)
    {
        $this->_container = $container;
        $this->_cacheFactory = $cacheFactory;
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
            $this->_cacheFactory->getAdapter()->isActive()
        ) {
            $controllerObject = $controller[0];

            if (false === strpos(get_class($controllerObject), 'Symfony\\Bundle')) {
                    
                if (null == $data = $this->_cacheFactory->getCacheData()) {
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
            $this->_cacheFactory
                ->setResponse($event->getResponse())
                ->setCacheData();
        }
        return;
    }
}
