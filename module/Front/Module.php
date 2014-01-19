<?php
namespace Front;

use Front\Model\Job;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;

use Front\Model\Category;

use Zend\Mvc\MvcEvent;

use Front\Model\CategoryTable;
use Front\Model\JobTable;
use Front\Model\UserTable;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;

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
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new Category());
                	return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
                'Front\Model\JobTable' =>  function($sm) {
                	$tableGateway = $sm->get('JobTableGateway');
                	$table = new JobTable($tableGateway);
                	return $table;
                },
                'JobTableGateway' => function ($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new Job());
                	return new TableGateway('job', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}