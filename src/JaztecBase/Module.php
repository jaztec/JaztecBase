<?php

namespace JaztecBase;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    ServiceProviderInterface
{

    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager()->getSharedManager();
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                'base_em' => function ($instance, $sm) {
                    if ($instance instanceof Mapper\AbstractDoctrineMapper) {
                        $instance->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
                    }
                },
            ),
        );
    }
}
