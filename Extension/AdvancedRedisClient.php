<?php
namespace Cent\RefrigeratorBundle\Extension;

/**
 * AdvancedRedisClient
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */
class AdvancedRedisClient extends \Predis\Client
{
    /**
     * KEYS
     * 
     * @param string $pattern
     * @return array
     */
    public function keys($pattern)
    {
        $options = $this->getOptions();
        $response = $this->__call('keys', array($pattern));

        if (isset($options->prefix) && !$response instanceof Predis\ResponseErrorInterface) {
            $length = strlen($options->prefix->getPrefix());
            $response = array_map(function ($key) use ($length) {
                return substr($key, $length);
            }, $response);
        }

        return $response;
    }
}
