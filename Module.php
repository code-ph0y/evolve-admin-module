<?php

namespace AdminModule;

use PPI\Framework\Module\AbstractModule;

class Module extends AbstractModule
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'AdminModule';
    }

    /**
     * Get the routes for this module
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->loadSymfonyRoutes(__DIR__ . '/resources/routes/symfony.yml');
    }

    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->loadConfig(__DIR__ . '/resources/config/config.php');
    }

    /**
     * Get the configuration for the Autoloader
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    /**
     * Get the service configuration
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array('factories' => array(
            'admin.users.storage' => function ($sm) {
                 return new \AdminModule\Storage\User($sm->get('datasource')->getConnection('main'));
            },

            'admin.user.activation.storage' => function ($sm) {
                 return new \AuthModule\Storage\UserActivation($sm->get('datasource')->getConnection('main'));
            },

            'admin.userlevels.storage' => function ($sm) {
                return new \AdminModule\Storage\UserLevel($sm->get('datasource')->getConnection('main'));
            }
        ));
    }
}
