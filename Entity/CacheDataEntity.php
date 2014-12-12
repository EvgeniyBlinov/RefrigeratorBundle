<?php
namespace Cent\RefrigeratorBundle\Entity;

/**
 * class_desc
 *
 * @package    package
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class CacheDataEntity 
{
    /**
     * @var array of attributes
     */
    private $_attributes = array();
    
    /**
     * @return array of default attributes
     */
    public function getDefaults()
    {
        return array(
            'meta'    => '',
            'headers' => '',
            'content' => '',
        );
    }
    
    /**
     * Constructor
     * 
     * @param mixed $attributes
     */
    public function __construct($attributes = null)
    {
        if (is_array($attributes) && count($attributes)) {
            $this->setAttributes($attributes);
        }
        
        if (is_string($attributes) && $attributes != null && ( $attributes = json_decode($attributes, true))) {
            $this->setAttributes($attributes);
        }
    }
    
    /**
     * @return array of attributes
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
    
    /**
     * @return array of attributes
     */
    public function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }
    
    /**
     * Set attributes
     * 
     * @param array $attributes
     * @return \Cent\RefrigeratorBundle\Entity\CacheDataEntity
     */
    public function setAttributes(array $attributes)
    {
        $this->_attributes = array_merge(
            (array) $this->_attributes,
            array_intersect_key($attributes, $this->getDefaults())
        );
        
        return $this;
    }
    
    /**
     * Get headers
     * 
     * @return array
     */
    public function getHeaders()
    {
        return (array) json_decode($this->_attributes['headers'], true);
    }
    
    /**
     * @return string of CacheDataEntity
     */
    public function __toString()
    {
        return json_encode($this->_attributes);
    }
}
