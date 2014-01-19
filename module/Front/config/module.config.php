<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Front\Controller\Category' => 'Front\Controller\CategoryController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);