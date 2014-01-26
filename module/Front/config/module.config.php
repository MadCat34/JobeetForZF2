<?php
return array(
    'jobeet' => array(
        'nb_job_by_category' => 10,
        'nb_job_pagination' => 4,
        'job_nb_valid_days' => 30,
    ),
    'router' => array(
        'routes' => array(
            'list_category_page' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/category/:slug[/page/[:page]]',
                    'constraints' => array(
                        'page'   => '[0-9]+',
                        'slug'   => '[a-z]+'
                    ),
                    'defaults' => array(
                        'module'     => 'Front',
                        'controller' => 'Front\Controller\Category',
                        'action'     => 'list',
                        'page'       => 1
                    ),
                ),
            ),
            'get_job' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/job/:company/:location/:id/:position',
                    'constraints' => array(
                        'company' => '[a-z0-9-]*',
                        'position' => '[a-z0-9-]*',
                        'location' => '[a-z0-9-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'module'     => 'Front',
                        'controller' => 'Front\Controller\Job',
                        'action'     => 'get',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Front\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
