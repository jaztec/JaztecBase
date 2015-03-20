<?php

namespace JaztecBase;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use JaztecBase\ORM\EntityManagerAwareInterface;

class Module implements 
    ServiceProviderInterface,
    AutoloaderProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'initializers' => [
                'jaztecEntityManager' => function ($instance, $sm) {
                    if ($instance instanceof EntityManagerAwareInterface) {
                        $instance->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
                    }
                },
            ],
        ];
    }
}
