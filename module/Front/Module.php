<?php
namespace Front;

use Front\Controller\CategoryController;
use Front\Controller\IndexController;
use Front\Controller\JobController;
use Zend\EventManager\Event;
use Zend\EventManager\StaticEventManager;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\MvcEvent;
use ZfcBase\Module\AbstractModule;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module extends AbstractModule implements ConfigProviderInterface
{

    protected $serviceManager;

    public function init(ModuleManagerInterface $manager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array(
            $this,
            'onBootstrap'
        ));
    }

    public function onBootstrap(Event $e)
    {
        $application = $e->getParam('application');
        $this->serviceManager = $application->getServiceManager();
        $application->getEventManager()->attach('dispatch', array(
            $this,
            'onDispatch'
        ), - 100);
    }

    public function onDispatch(MvcEvent $e)
    {
        $matches = $e->getRouteMatch();
        $module = $matches->getParam('module');
        
        if (strpos($module, __NAMESPACE__) === 0) {
            $templatePathStack = $this->serviceManager->get('Zend\View\Resolver\TemplatePathStack');
            $templatePathStack->addPath(__DIR__ . '/view');
        }
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Front\Controller\Category' => function (ControllerManager $cm)
                {
                    $sm = $cm->getServiceLocator();
                    $config = $sm->get('Config');
                    $config = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Jobeet\Model\CategoryTable');
                    $job = $sm->get('Jobeet\Model\JobTable');
                    $controller = new CategoryController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                },
                'Front\Controller\Job' => function (ControllerManager $cm)
                {
                    $sm = $cm->getServiceLocator();
                    $config = $sm->get('Config');
                    $config = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Jobeet\Model\CategoryTable');
                    $job = $sm->get('Jobeet\Model\JobTable');
                    $controller = new JobController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                },
                'Front\Controller\Index' => function (ControllerManager $cm)
                {
                    $sm = $cm->getServiceLocator();
                    $config = $sm->get('Config');
                    $config = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Jobeet\Model\CategoryTable');
                    $job = $sm->get('Jobeet\Model\JobTable');
                    $controller = new IndexController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'jobsessions' => 'Front\View\Helper\JobSessions',
            ),
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getDir()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }
}
