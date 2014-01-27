<?php
return array(
    'jobeet' => array(
        'admin_element_pagination' => 5,
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
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
                            ),
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
                                        'action' => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
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
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/job/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Job',
                                        'action' => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
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
                                'params' => array('action' => 'add')
                            ),
                            'edit_category' => array(
                                'label' => 'Edit category',
                                'route' => 'zfcadmin/category/action',
                                'params' => array('action' => 'edit')
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
                                'params' => array('action' => 'add')
                            ),
                            'edit_job' => array(
                                'label' => 'Edit job',
                                'route' => 'zfcadmin/job/action',
                                'params' => array('action' => 'edit')
                            )
                        )
                    ),
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator' => __DIR__ . '/../view/layout/adminPagination.phtml',
            'breadcrumb' => __DIR__ . '/../view/layout/adminBreadcrumb.phtml',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'admin_navigation' => 'ZfcAdmin\Navigation\Service\AdminNavigationFactory',
        ),
    ),
);