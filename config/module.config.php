<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Doctrine\Initializer\ObjectManagerInitializer;
use MSBios\Voting\Initializer\PollManagerInitializer;
use MSBios\Voting\Initializer\VoteManagerInitializer;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [

        ],
        'aliases' => [

        ],
        'initializers' => [

        ]
    ],

    'controller_plugins' => [
        'factories' => [

        ],
        'aliases' => [

        ],
        'initializers' => [

        ]
    ],

    'form_elements' => [
        'factories' => [

        ],
        'aliases' => [

        ],
    ],

    'view_helpers' => [
        'factories' => [

        ],
        'aliases' => [

        ],
        'initializers' => [

        ]
    ],
];
