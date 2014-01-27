<?php
    namespace Front;

    use Front\Controller\CategoryController;
    use Front\Controller\IndexController;
    use Front\Controller\JobController;
    use Zend\Mvc\Controller\ControllerManager;
    use Zend\Mvc\ModuleRouteListener;
    use Zend\Mvc\MvcEvent;

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
    
        public function getControllerConfig()
        {
            return array(
                'factories' => array(
                    'Front\Controller\Category' => function(ControllerManager $cm) {
                        $sm   = $cm->getServiceLocator();
                        $config     = $sm->get('Config');
                        $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                        $category = $sm->get('Jobeet\Model\CategoryTable');
                        $job = $sm->get('Jobeet\Model\JobTable');
                        $controller = new CategoryController($category, $job);
                        $controller->setConfig($config);
                        return $controller;
                    },
                    'Front\Controller\Job' => function(ControllerManager $cm) {
                        $sm   = $cm->getServiceLocator();
                        $config     = $sm->get('Config');
                        $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                        $category = $sm->get('Jobeet\Model\CategoryTable');
                        $job = $sm->get('Jobeet\Model\JobTable');
                        $controller = new JobController($category, $job);
                        $controller->setConfig($config);
                        return $controller;
                    },
                    'Front\Controller\Index' => function(ControllerManager $cm) {
                        $sm   = $cm->getServiceLocator();
                        $config     = $sm->get('Config');
                        $config     = isset($config['jobeet']) ? $config['jobeet'] : array();
                        $category = $sm->get('Jobeet\Model\CategoryTable');
                        $job = $sm->get('Jobeet\Model\JobTable');
                        $controller = new IndexController($category, $job);
                        $controller->setConfig($config);
                        return $controller;
                    },
                ),
            );
        }
    }
