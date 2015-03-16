<?php

namespace JaztecBase;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    ServiceProviderInterface
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
                'base_em' => function ($instance, $sm) {
                    if ($instance instanceof Mapper\AbstractDoctrineMapper) {
                        $instance->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
                    }
                },
            ],
        ];
    }
}
