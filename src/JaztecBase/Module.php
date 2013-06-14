<?php

namespace JaztecBase;

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
