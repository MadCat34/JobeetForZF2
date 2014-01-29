<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'bjyauthorize' => array(
        // default role for unauthenticated users
        'default_role' => 'guest',
        
        // identity provider service name
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
        
        // Role providers to be used to load all available roles into Zend\Permissions\Acl\Acl
        // Keys are the provider service names, values are the options to be passed to the provider
        'role_providers' => array(
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table' => 'user_role',
                'role_id_field' => 'role_id',
                'parent_role_field' => 'parent'
            )
        ),
        
        // Guard listeners to be attached to the application event manager
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcadmin', 'roles' => array('admin')),
                array('route' => 'zfcadmin/logout', 'roles' => array('user', 'admin')),
                array('route' => 'zfcadmin/login', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'zfcadmin/authenticate', 'roles' => array( 'guest', 'user', 'admin')),
                array('route' => 'zfcadmin/register', 'roles' => array('guest')),
                array('route' => 'zfcadmin/category', 'roles' => array('admin')),
                array('route' => 'zfcadmin/category/action', 'roles' => array('admin')),
                array('route' => 'zfcadmin/job', 'roles' => array('admin')),
                array('route' => 'zfcadmin/job/action', 'roles' => array('admin')),
                array('route' => 'home', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'home/logout', 'roles' => array('user', 'admin')),
                array('route' => 'home/add_job', 'roles' => array('user', 'admin')),
                array('route' => 'home/login', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'home/authenticate', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'home/register', 'roles' => array('guest')),
                array('route' => 'home/list_category_page', 'roles' => array('guest', 'user', 'admin')),
                array('route' => 'home/get_job', 'roles' => array('guest', 'user', 'admin'))
            )
        )
    )
);