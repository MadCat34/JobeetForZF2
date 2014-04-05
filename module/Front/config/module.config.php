<?php
namespace Front;

return array(
    'jobeet' => array(
        'nb_job_by_category' => 10,
        'nb_job_pagination' => 4,
        'job_nb_valid_days' => 30
    ),
    'zfcuser' => array(
        'enable_registration' => true,
        'use_redirect_parameter_if_present' => true
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'module' => 'Front',
                        'controller' => 'Front\Controller\Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'login'
                            )
                        )
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'authenticate'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'logout'
                            )
                        )
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'register'
                            )
                        )
                    ),
                    'changepassword' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changepassword'
                            )
                        )
                    ),
                    'changeemail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail'
                            )
                        )
                    ),
                    'add_category' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '{add}/{category}[/]',
                            'defaults' => array(
                                'module' => 'Front',
                                'controller' => 'Front\Controller\Category',
                                'action' => 'add'
                            )
                        )
                    ),
                    'add_job' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '{add}/{job}[/]',
                            'defaults' => array(
                                'module' => 'Front',
                                'controller' => 'Front\Controller\Job',
                                'action' => 'add'
                            )
                        )
                    ),
                    'list_category_page' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '{category}/:slug[/page/[:page]]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                                'slug' => '[a-z]+'
                            ),
                            'defaults' => array(
                                'module' => 'Front',
                                'controller' => 'Front\Controller\Category',
                                'action' => 'list',
                                'page' => 1
                            )
                        )
                    ),
                    'get_job' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '{job}/:company/:location/:id/:position',
                            'constraints' => array(
                                'company' => '[a-z0-9-]*',
                                'position' => '[a-z0-9-]*',
                                'location' => '[a-z0-9-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'module' => 'Front',
                                'controller' => 'Front\Controller\Job',
                                'action' => 'get'
                            )
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/view'
        )
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ),
        ),
    ),
);
