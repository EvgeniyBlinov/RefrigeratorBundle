<?php
namespace Cent\RefrigeratorBundle\Extension\OptionsAdapter;

/**
 * DoctrineOptionsAdapter
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

interface OptionsAdapterIntarface 
{
    /**
     * Get option
     * 
     * @param array $params
     * @return array
     */
    public function getOption($params);
}
