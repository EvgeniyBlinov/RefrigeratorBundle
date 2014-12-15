<?php
namespace Cent\RefrigeratorBundle\Extension\OptionsAdapter;
/**
 * DoctrineOptionsAdapter
 *
 * @package    Refrigerator
 * @author     Evgeniy Blinov <evgeniy_blinov@mail.ru>
 */

class DoctrineOptionsAdapter implements OptionsAdapterIntarface
{
    private $_repository;
    
    public function __construct(\Doctrine\ORM\EntityRepository $repository)
    {    
        $this->_repository = $repository;
    }
    
    /**
     * Get option
     * 
     * @param array $params
     * @return array
     */
    public function getOption($params)
    {
        $qb = $this->_repository->createQueryBuilder('e');
        foreach ($params as $key => $value) {
            $qb->andWhere(sprintf('e.%1$s = :%1$s', $key))
                ->setParameter($key, $value);
        }
        
        return $qb->getQuery()->getArrayResult();
    }
}
