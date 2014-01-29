<?php
return array(
    'modules' => array(
        'BjyProfiler',
        'ZfcBase',
        'ZfcUser',
        'BjyAuthorize',
        'ZendDeveloperTools',
        'ZfcAdmin',
        'Front',
        'Admin',
        'Jobeet'
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        ),
        'module_paths' => array(
            './module',
            './vendor'
        )
    )
);
