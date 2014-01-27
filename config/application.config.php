<?php
return array(
    'modules' => array(
        'Front',
        'Jobeet',
        'ZendDeveloperTools',
        'BjyProfiler',
        'ZfcAdmin',
        'Admin',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
