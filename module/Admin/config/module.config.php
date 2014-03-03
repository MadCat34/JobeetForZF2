<?php
namespace Admin;

return array(
    'jobeet' => array(
        'admin_element_pagination' => 10
    ),
    'zfcuser' => array(
        'enable_registration' => false,
        'auth_identity_fields' => array(
            'username'
        ),
        'use_redirect_parameter_if_present' => true,
        'login_redirect_route' => 'zfcadmin',
        'logout_redirect_route' => 'zfcadmin/login'
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'login'
                            )
                        )
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'authenticate'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'logout'
                            )
                        )
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'register'
                            )
                        )
                    ),
                    'changepassword' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changepassword'
                            )
                        )
                    ),
                    'changeemail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail'
                            )
                        )
                    ),
                    'category' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/category[/page/:page]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Category',
                                'action' => 'index',
                                'page' => 1
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/category/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+',
                                        'page' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Category',
                                        'action' => 'index'
                                    )
                                ),
                                'may_terminate' => true
                            )
                        )
                    ),
                    'job' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/job[/page/:page]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Job',
                                'action' => 'index',
                                'page' => 1
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/job/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Job',
                                        'action' => 'index'
                                    )
                                ),
                                'may_terminate' => true
                            )
                        )
                    )
                )
            )
        )
    ),
    'navigation' => array(
        'admin' => array(
            'index' => array(
                'label' => 'Admin',
                'route' => 'zfcadmin',
                'pages' => array(
                    'category' => array(
                        'label' => 'Category',
                        'route' => 'zfcadmin/category',
                        'pages' => array(
                            'new_category' => array(
                                'label' => 'New category',
                                'route' => 'zfcadmin/category/action',
                                'params' => array(
                                    'action' => 'add'
                                )
                            ),
                            'edit_category' => array(
                                'label' => 'Edit category',
                                'route' => 'zfcadmin/category/action',
                                'params' => array(
                                    'action' => 'edit'
                                )
                            )
                        )
                    ),
                    'job' => array(
                        'label' => 'Job',
                        'route' => 'zfcadmin/job',
                        'pages' => array(
                            'new_job' => array(
                                'label' => 'New job',
                                'route' => 'zfcadmin/job/action',
                                'params' => array(
                                    'action' => 'add'
                                )
                            ),
                            'edit_job' => array(
                                'label' => 'Edit job',
                                'route' => 'zfcadmin/job/action',
                                'params' => array(
                                    'action' => 'edit'
                                )
                            )
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'template_map' => array(
            'paginator' => __DIR__ . '/../view/layout/adminPagination.phtml',
            'breadcrumb' => __DIR__ . '/../view/layout/adminBreadcrumb.phtml',
            'userNav' => __DIR__ . '/../view/layout/widgetNavUser.phtml'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'admin_navigation' => 'ZfcAdmin\Navigation\Service\AdminNavigationFactory',
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ),
            array(
                'type' => 'phpArray',
                'base_dir' => './vendor/zendframework/zendframework/resources/languages/',
                'pattern'  => 'fr/Zend_Validate.php',
            ),
        ),
    ),
);
