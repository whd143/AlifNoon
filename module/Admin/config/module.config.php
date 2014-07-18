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
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    
                    
                    
                    'login' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                              '__NAMESPACE__' => 'Admin\Controller',
                              'controller'    => 'Auth',
                              'action'        => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'recover' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/recover',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Auth',
                                      'action'        => 'recover'
                                    ),
                                ),
                            ),
                            'check' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/check',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Auth',
                                      'action'        => 'check'
                                    ),
                                ),
                            ),
                            'destroy' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/destroy',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Auth',
                                      'action'        => 'destroy'
                                    ),
                                ),
                            ),
                          ),
                        ),
                    
                    
                    
                    'employees' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/employees',
                            'defaults' => array(
                              '__NAMESPACE__' => 'Admin\Controller',
                              'controller'    => 'Employee',
                              'action'        => 'index'
                            ),
                        ),
                    ),


                    'employee' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/employee',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller'    => 'Employee',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(

                            'view' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '[/:employee_id]',
                                    'constraints' => array(
                                        'employee_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Employee',
                                      'action'        => 'view'
                                    ),
                                ),
                            ),
                            'profile' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/profile',
                                    'constraints' => array(
                                        'employee_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Employee',
                                      'action'        => 'profile'
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(

                                    'update' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route'    => '[/update]',
                                            'defaults' => array(
                                              '__namespace__' => 'admin\controller',
                                              'controller'    => 'employee',
                                              'action'        => 'updateprofile'
                                            ),
                                        ),
                                    ),
                                  )



                            ),
                            'password' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/password',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Employee',
                                      'action'        => 'password'
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                      '__namespace__' => 'admin\controller',
                                      'controller'    => 'employee',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                            'update' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/update/:employee_id',
                                    'defaults' => array(
                                      '__namespace__' => 'admin\controller',
                                      'controller'    => 'employee',
                                      'action'        => 'updateprofile'
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/delete/:employee_id',
                                    'defaults' => array(
                                      '__namespace__' => 'admin\controller',
                                      'controller'    => 'employee',
                                      'action'        => 'delete'
                                    ),
                                ),
                            ),
                            'roles' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:employee_id/roles',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Employee',
                                      'action'        => 'roles'
                                    ),
                                ),
                            ),
                        )
                    ),










                    
                    'roles' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/roles',
                            'defaults' => array(
                              '__NAMESPACE__' => 'Admin\Controller',
                              'controller'    => 'Role',
                              'action'        => 'index'
                            ),
                        ),
                    ),


                    'role' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/role',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller'    => 'Role',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(

                            'view' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '[/:role_id]',
                                    'constraints' => array(
                                        'role_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Role',
                                      'action'        => 'view'
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Role',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                            'update' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/update',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Role',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:role_id',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Role',
                                      'action'        => 'delete'
                                    ),
                                ),
                            ),
                            'resources' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:role_id/resources',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Role',
                                      'action'        => 'resources'
                                    ),
                                ),
                            ),
                        )
                    ),





                    'resources' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/resources',
                            'defaults' => array(
                              '__NAMESPACE__' => 'Admin\Controller',
                              'controller'    => 'Resource',
                              'action'        => 'index'
                            ),
                        ),
                    ),


                    'resource' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/resource',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller'    => 'Resource',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(

                            'view' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '[/:resource_id]',
                                    'constraints' => array(
                                        'resource_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Resource',
                                      'action'        => 'view'
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Resource',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                            'update' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/update',
                                    'defaults' => array(
                                      '__namespace__' => 'admin\controller',
                                      'controller'    => 'resource',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/delete/:resource_id',
                                    'constraints' => array(
                                        'resource_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__namespace__' => 'admin\controller',
                                      'controller'    => 'resource',
                                      'action'        => 'delete'
                                    ),
                                ),
                            ),
                        )
                    ),





                    'departments' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/departments',
                            'defaults' => array(
                              '__NAMESPACE__' => 'Admin\Controller',
                              'controller'    => 'Department',
                              'action'        => 'index'
                            ),
                        ),
                    ),


                    'department' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/department',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller'    => 'Department',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(

                            'view' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '[/:department_id]',
                                    'constraints' => array(
                                        'department_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Department',
                                      'action'        => 'view'
                                    ),
                                ),
                            ),
                            'update' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/update[/:department_id]',
                                    'constraints' => array(
                                        'department_id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Department',
                                      'action'        => 'update'
                                    ),
                                ),
                            ),
                            
                            
                            'add' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                      '__NAMESPACE__' => 'Admin\Controller',
                                      'controller'    => 'Department',
                                      'action'        => 'add'
                                    ),
                                ),
                            ),
                        )
                    )

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
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'      => 'Admin\Controller\IndexController',
            'Admin\Controller\Employee'   => 'Admin\Controller\EmployeeController',
            'Admin\Controller\Role'       => 'Admin\Controller\RoleController',
            'Admin\Controller\Resource'   => 'Admin\Controller\ResourceController',
            'Admin\Controller\Department' => 'Admin\Controller\DepartmentController',
            'Admin\Controller\Auth'       => 'Admin\Controller\AuthController'
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
            'admin/index/index'       => __DIR__ . '/../view/admin/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array('ViewJsonStrategy')
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
