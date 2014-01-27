<?php
    namespace Admin;

    use Admin\Controller\CategoryController;
    use Admin\Controller\JobController;
    use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
    use Zend\Mvc\Controller\ControllerManager;
    use Zend\Mvc\Controller\Plugin\FlashMessenger;
    use Zend\Mvc\ModuleRouteListener;
    use Zend\Mvc\MvcEvent;
	
    class Module implements AutoloaderProviderInterface
    {
        public function onBootstrap(MvcEvent $e)
        {
            $e->getApplication()->getServiceManager()->get('translator');
            $eventManager = $e->getApplication()->getEventManager();
            $moduleRouteListener = new ModuleRouteListener();
            $eventManager->attach(MvcEvent::EVENT_RENDER, function($e) {
                $flashMessenger = new FlashMessenger();
                
                $messages = array_merge(
                    $flashMessenger->getSuccessMessages(),
                    $flashMessenger->getInfoMessages(),
                    $flashMessenger->getErrorMessages(),
                    $flashMessenger->getMessages()
                );
                
                if ($flashMessenger->hasMessages()) {
                    $e->getViewModel()->setVariable('flashMessages', $messages);
                }
            });
            
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
                        __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                    ),
                ),
            );
        }
    
        public function getConfig()
        {
            return include __DIR__ . '/config/module.config.php';
        }
        
        public function getControllerConfig()
        {
            return array(
                'factories' => array(
                    'Admin\Controller\Category'    => function(ControllerManager $cm) {
                        $sm   = $cm->getServiceLocator();
                        $config     = $sm->get('Config');
                        $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                        $category = $sm->get('Jobeet\Model\CategoryTable');
                        $job = $sm->get('Jobeet\Model\JobTable');
                        $controller = new CategoryController($category, $job);
                        $controller->setConfig($config);
                        return $controller;
                    },
                    'Admin\Controller\Job'    => function(ControllerManager $cm) {
                        $sm   = $cm->getServiceLocator();
                        $config     = $sm->get('Config');
                        $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                        $category = $sm->get('Jobeet\Model\CategoryTable');
                        $job = $sm->get('Jobeet\Model\JobTable');
                        $controller = new JobController($category, $job);
                        $controller->setConfig($config);
                        return $controller;
                    },
                ),
            );
        }
        
        public function getServiceConfig() {
            return array(
                'factories' => array(
                    'jobeet_flashmessenger' => function ($sm) {
                        $viewModel = $sm->get('view_manager')->getViewModel();
                        $controller = $sm->get('ControllerPluginManager');
                        $flashMessenger = $controller->get('FlashMessenger');
        
                        return $viewModel->setVariable('messages', $flashMessenger->getMessages());
                    },
                )
            );
        }
    }
