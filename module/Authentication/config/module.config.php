<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Authentication\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            /**
             * The following is a route to simplify getting started creating new 
             * controllers and actions without needing to create a new module. 
             * Simply drop new controllers in, and you can access them using the 
             * path /application/:controller/:action
             */
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Authentication\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'logout' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Authentication\Controller',
                                'controller' => 'Index',
                                'action' => 'logout'
                            ),
                        ),
                    ),
                    'remind' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remind',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Authentication\Controller',
                                'controller' => 'Index',
                                'action' => 'remindpassword'
                            ),
                        ),
                    ),
                    'renewPassword' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/renewPassword/:token',
                            'constraints' => array(
                                'token' => '[\s\S]{32}',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Authentication\Controller',
                                'controller' => 'Index',
                                'action' => 'renewpassword'
                            ),
                        ),
                    ),
                    'dashboard' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/dashboard',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Authentication\Controller',
                                'controller' => 'Dashboard',
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            'AuthService' => 'Authentication\Service\Authentication',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Authentication\Controller\Index' => 'Authentication\Controller\IndexController',
            'Authentication\Controller\Dashboard' => 'Authentication\Controller\DashboardController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/default-layout.phtml',
            'layout/admin-layout' => __DIR__ . '/../view/layout/admin-layout.phtml',
            //'authentication/index/index' => __DIR__ . '/../view/authentication/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'tfd_config' => array(
        'email' => array(
            'sender_title' => 'TFD Team',
            'sender_email' => 'info@thefreshdiet.com'
        )
    ),
    /**
     * Placeholder for console routes
     */
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
