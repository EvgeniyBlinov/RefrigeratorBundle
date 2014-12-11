<?php
namespace Cent\RefrigeratorBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent; 
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * CacheListener
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class CacheListener 
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $security_context;
    
    /**
     * Constructor
     * 
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $security_context
     */
    public function __construct(SecurityContextInterface $security_context)
    {
        $this->security_context = $security_context;
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
        
        if (!is_array($controller)) {    // not a object but a different kind of callable. Do nothing
            return;
        }
        $controllerObject = $controller[0];

        if (false === strpos(get_class($controllerObject), 'Symfony\\Bundle')) {
            //echo "<pre>";var_dump(
            //get_class_methods(
            //$event
            //)
            //);die;
            
            //preg_match('/(?<key>[a-z]+::[a-z]+$)/i', $controllerObject
                //->getRequest()
                //->attributes
                //->get('_controller'),
                //$matches);
            
            //$key = isset($matches['key']) ?
                //$matches['key'] :
            $key = $this->getKey($event->getRequest());

            //echo "<pre>";var_dump(
                //$key
            //);die;
        }
        
    }
    
    /**
     * onKernelResponse
     * 
     * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
     * @return void
     */
    public function onKernelResponse(PostResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        
        $methods = get_class_methods(
        $event
        );
        asort($methods);
        
        $methods = get_class_methods(
        $response
        );
        asort($methods);
        
        $key = $this->getKey($event->getRequest());
        //$response->getContent()
        
        
        /**
         * Записать хедеры и куки по отдельному в ключ
         * хранить хедеры и контент
         *
         
         {
            "headers": "",
            "content": "",
            "meta": ""
         }
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
        
        echo "<pre>";var_dump(
        //$methods
        //->sendHeaders()
        headers_list()
        //->getHeaders()
        //->getContent()
        );
        //die;
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
