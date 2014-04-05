<?php
namespace Admin;

use Admin\Controller\CategoryController;
use Admin\Controller\JobController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZfcBase\Module\AbstractModule;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\I18n\Translator;

class Module extends AbstractModule implements ConfigProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $eventManager->attach(MvcEvent::EVENT_RENDER, function ($e)
        {
            $flashMessenger = new FlashMessenger();

            $messages = array_merge($flashMessenger->getSuccessMessages(), $flashMessenger->getInfoMessages(), $flashMessenger->getErrorMessages(), $flashMessenger->getMessages());

            if ($flashMessenger->hasMessages()) {
                $e->getViewModel()->setVariable('flashMessages', $messages);
            }
        });

        $eventManager->attach('route', array($this, 'onPreRoute'), 100);
        $moduleRouteListener->attach($eventManager);
    }

    public function onPreRoute($e){
        $app      = $e->getTarget();
        $serviceManager       = $app->getServiceManager();
        $serviceManager->get('router')->setTranslator($serviceManager->get('translator'));
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Admin\Controller\Category' => function (ControllerManager $cm)
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
                'Admin\Controller\Job' => function (ControllerManager $cm)
                {
                    $sm = $cm->getServiceLocator();
                    $config = $sm->get('Config');
                    $config = isset($config['jobeet']) ? $config['jobeet'] : array();
                    $category = $sm->get('Jobeet\Model\CategoryTable');
                    $job = $sm->get('Jobeet\Model\JobTable');
                    $controller = new JobController($category, $job);
                    $controller->setConfig($config);
                    return $controller;
                }
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'jobeet_flashmessenger' => function ($sm) {
                    $viewModel = $sm->get('view_manager')->getViewModel();
                    $controller = $sm->get('ControllerPluginManager');
                    $flashMessenger = $controller->get('FlashMessenger');

                    return $viewModel->setVariable('messages', $flashMessenger->getMessages());
                }
            )
        );
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
