<?php
namespace Cent\RefrigeratorBundle\Extension;

use Doctrine\ORM\EntityRepository;
use Cent\RefrigeratorBundle\Extension\OptionsAdapter\DoctrineOptionsAdapter;

/**
 * RefrigeratorOptionsFactory
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class RefrigeratorOptionsFactory 
{
    private $_options;
    private $_adapter;
    
    /**
     * Constructor
     * 
     * @param mixed $options
     */
    public function __construct($options)
    {
        $this->_options = $options;
        
        if ($options instanceof \Doctrine\ORM\EntityRepository) {
            $this->_adapter = new DoctrineOptionsAdapter($options);
        }
    }
    
    /**
     * Call adapter method
     * 
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (method_exists($this->_adapter, $name)) {
            return call_user_func_array(array($this->_adapter, $name), $args);
        }
    }
}
