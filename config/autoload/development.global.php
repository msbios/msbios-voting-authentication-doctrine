<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine;

use MSBios\Authentication\Initializer\AuthenticationServiceInitializer;
use Zend\Router\Http\Method;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host' => '127.0.0.1',
                    'user' => 'root',
                    'password' => 'root',
                    'dbname' => 'portal.dev',
                ]
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'home' => [
                'may_terminate' => true,
                'child_routes' => [
                    'vote' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'vote[/]',
                            'defaults' => [
                                'action' => 'vote'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            [
                                'type' => Method::class,
                                'options' => [
                                    'verb' => 'post'
                                ]
                            ]
                        ]
                    ],
                    'undo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'undo/:option_id[/[:relation[/]]]',
                            'defaults' => [
                                'action' => 'undo'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            [
                                'type' => Method::class,
                                'options' => [
                                    'verb' => 'get'
                                ]
                            ]
                        ]
                    ],
                    'login' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'login[/]',
                            'defaults' => [
                                'action' => 'login'
                            ],
                        ]
                    ]
                ]
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                InvokableFactory::class,
        ],
        'aliases' => [
            \MSBios\Application\Controller\IndexController::class =>
                Controller\IndexController::class
        ],
        'initializers' => [
            AuthenticationServiceInitializer::class =>
                new AuthenticationServiceInitializer
        ]
    ],

    'view_manager' => [
        'template_map' => [
            // Template map
        ],
        'template_path_stack' => [
            __DIR__ . '/../../view',
        ],
    ],

    \MSBios\Assetic\Module::class => [

        'paths' => [
            __DIR__ . '/../../vendor/msbios/application/themes/default/public/',
        ],

        'maps' => [
            // css
            'default/css/bootstrap.min.css' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/css/bootstrap.min.css',
            'default/css/bootstrap-theme.min.css' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/css/bootstrap-theme.min.css',
            'default/css/style.css' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/css/style.css',

            // js
            'default/js/jquery-3.1.0.min.js' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/js/jquery-3.1.0.min.js',
            'default/js/bootstrap.min.js' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/js/bootstrap.min.js',

            // imgs
            'default/img/zf-logo-mark.svg' =>
                __DIR__ . '/../../vendor/msbios/application/themes/default/public/img/zf-logo-mark.svg',

            // css
            'limitless/assets/css/icons/fontawesome/styles.min.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/icons/fontawesome/styles.min.css',
            'limitless/assets/css/bootstrap.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/bootstrap.css',
            'limitless/assets/css/colors.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/colors.css',
            'limitless/assets/css/components.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/components.css',
            'limitless/assets/css/core.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/core.css',
            'limitless/assets/css/icons/icomoon/styles.css' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/icons/icomoon/styles.css',
            'limitless/assets/css/icons/icomoon/fonts/icomoon.woff' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/icons/icomoon/fonts/icomoon.woff',
            'limitless/assets/css/icons/icomoon/fonts/icomoon.ttf' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/css/icons/icomoon/fonts/icomoon.ttf',

            // js
            'limitless/assets/js/plugins/loaders/pace.min.js' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/js/plugins/loaders/pace.min.js',
            'limitless/assets/js/core/libraries/jquery.min.js' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/js/core/libraries/jquery.min.js',
            'limitless/assets/js/core/libraries/bootstrap.min.js' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/js/core/libraries/bootstrap.min.js',
            'limitless/assets/js/plugins/loaders/blockui.min.js' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/js/plugins/loaders/blockui.min.js',
            'limitless/assets/js/core/app.js' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/js/core/app.js',
            // images
            'limitless/assets/images/logo_light.png' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/images/logo_light.png',
            'limitless/assets/images/logo_light_msbios.png' =>
                __DIR__ . '/../../vendor/msbios/cpanel/themes/limitless/public/assets/images/logo_light_msbios.png',
        ],
    ],

    \MSBios\Voting\Module::class => [

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\VoteRepositoryResolver::class => -100
         * ]
         */
        'vote_resolvers' => [

        ],

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\CheckRepositoryResolver::class => -100
         * ]
         */
        'check_resolvers' => [
        ]
    ]
];
