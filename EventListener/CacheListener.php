<?php
namespace Cent\RefrigeratorBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\SecurityContextInterface; 

/**
 * CacheListener
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class CacheListener 
{
    private $security_context;
    
    public function __construct(SecurityContextInterface $security_context)
    {
        $this->security_context = $security_context;
    }
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
        // not a object but a different kind of callable. Do nothing
            return;
        }
        $controllerObject = $controller[0];
        echo "<pre>";var_dump(
        $controllerObject
        );die;
        // skip initializing for exceptions
        if ($controllerObject instanceof ExceptionController) {
            return;
        }
        if ($controllerObject instanceof InitializableControllerInterface) {
        // this method is the one that is part of the interface.
            $controllerObject->initialize($event->getRequest(), $this->security_context);
        }
    } 
}
