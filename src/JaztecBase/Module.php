<?php

namespace JaztecBase;

use \Zend\ModuleManager\ModuleManager;

class Module
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

}
