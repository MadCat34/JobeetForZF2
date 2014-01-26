<?php
namespace Front;

use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Front\Model\CategoryTable;
use Front\Model\JobTable;
use Front\Model\Category;
use Front\Model\Job;
use Front\Controller\IndexController;
use Front\Controller\CategoryController;
use Front\Controller\JobController;
use Zend\Stdlib\Hydrator\ArraySerializable as ArraySerializableHydrator;
use Zend\Db\ResultSet\HydratingResultSet;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Front\Model\CategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new HydratingResultSet(
                        new ArraySerializableHydrator(),
                        new Category()
                    );
                    
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
                'Front\Model\JobTable' =>  function($sm) {
                    $tableGateway = $sm->get('JobTableGateway');
                    $table = new JobTable($tableGateway);
                    return $table;
                },
                'JobTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new HydratingResultSet(
                        new ArraySerializableHydrator(),
                        new Job()
                    );
                    return new TableGateway('job', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Front\Controller\Category'    => function(ControllerManager $cm) {
                    $sm   = $cm->getServiceLocator();
                    $config     = $sm->get('Config');
                    $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Front\Model\CategoryTable');
                    $job = $sm->get('Front\Model\JobTable');
                    $controller = new CategoryController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                },
                'Front\Controller\Job'    => function(ControllerManager $cm) {
                    $sm   = $cm->getServiceLocator();
                    $config     = $sm->get('Config');
                    $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Front\Model\CategoryTable');
                    $job = $sm->get('Front\Model\JobTable');
                    $controller = new JobController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                },
                'Front\Controller\Index'    => function(ControllerManager $cm) {
                    $sm   = $cm->getServiceLocator();
                    $config     = $sm->get('Config');
                    $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Front\Model\CategoryTable');
                    $job = $sm->get('Front\Model\JobTable');
                    $controller = new IndexController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                },
            ),
        );
    }
}
