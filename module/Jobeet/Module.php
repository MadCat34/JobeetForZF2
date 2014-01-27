<?php
    namespace Jobeet;
    
    use Jobeet\Model\Category;
    use Jobeet\Model\CategoryTable;
    use Jobeet\Model\Job;
    use Jobeet\Model\JobTable;
    use Zend\Db\ResultSet\HydratingResultSet;
    use Zend\Db\TableGateway\TableGateway;
    use Zend\Stdlib\Hydrator\ArraySerializable as ArraySerializableHydrator;
    
    class Module
    {
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
                    'Jobeet\Model\CategoryTable' =>  function($sm) {
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
                    'Jobeet\Model\JobTable' =>  function($sm) {
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
    }
