<?php
$settings = array(
    'zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
    'user_entity_class' => 'ZfcUser\Entity\User',
    'enable_registration' => true,
    'enable_username' => true,
    'auth_adapters' => array( 100 => 'ZfcUser\Authentication\Adapter\Db' ),
    'enable_display_name' => true,
    'auth_identity_fields' => array('email', 'username'),
    'login_form_timeout' => 300,
    'user_form_timeout' => 600,
    'login_after_registration' => false,
    'use_registration_form_captcha' => false,
    'use_redirect_parameter_if_present' => true,

    //'user_login_widget_view_template' => 'zfc-user/user/login.phtml',
    //'login_redirect_route' => 'zfcuser',
    //'logout_redirect_route' => 'zfcuser/login',

    //'password_cost' => 14,
    //'enable_user_state' => true,

    //'default_user_state' => 1,
    //'allowed_login_states' => array( null, 1 ),
    
    'table_name' => 'user',
);

/**
 * You do not need to edit below this line
 */
return array(
    'zfcuser' => $settings,
    'service_manager' => array(
        'aliases' => array(
            'zfcuser_zend_db_adapter' => (isset($settings['zend_db_adapter'])) ? $settings['zend_db_adapter']: 'Zend\Db\Adapter\Adapter',
        ),
    ),
);
