<?php
return array(
    'jobeet' => array(
        'nb_job_by_category' => 10,
        'nb_job_pagination' => 4,
        'job_nb_valid_days' => 30,
    ),
    'service_manager' => array(
        'factories' => array(
            'Jobeet/Model/Category' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $category = new \Jobeet\Model\Category();
                $category->setDbAdapter($dbAdapter);
                return $category;
            },
            'Jobeet/Model/Job' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $job = new \Jobeet\Model\Job();
                $job->setDbAdapter($dbAdapter);
                return $job;
            },
        ),
    ),
);
