<?php
namespace Jobeet;

return array(
    __NAMESPACE__ => array(
        'options' => array(
            'routes' => array(
                'backend' => 'zfcadmin',
                'backend-login' => 'zfcadmin/login',
                'frontend' => 'home',
                'frontend-login' => 'home/login'
            )
        )
    ),
    'jobeet' => array(
        'nb_job_by_category' => 10,
        'nb_job_pagination' => 4,
        'job_nb_valid_days' => 30
    ),
    'bjyauthorize' => array(
        'unauthorized_strategy' => 'Jobeet\View\UnauthorizedStrategy'
    ),
    'service_manager' => array(
        'factories' => array(
            'BjyAuthorize\View\UnauthorizedStrategy' => 'Jobeet\View\UnauthorizedStrategy'
        )
    )
);
