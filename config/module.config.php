<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine;

use MSBios\Authentication\AuthenticationServiceInitializer;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'service_manager' => [
        'factories' => [

            // managers
            VoteManager::class =>
                Factory\VoteManagerFactory::class,
            VoteResolver::class =>
                Factory\VoteResolverFactory::class,

            // resolvers
            Resolver\CheckCookieResolver::class =>
                InvokableFactory::class,
            Resolver\CheckRepositoryResolver::class =>
                InvokableFactory::class,
            Resolver\VoteCookieResolver::class =>
                InvokableFactory::class,
            Resolver\VoteRepositoryResolver::class =>
                InvokableFactory::class
        ],
        'aliases' => [
            \MSBios\Voting\VoteManager::class =>
                VoteManager::class,
        ],
        'initializers' => [
            AuthenticationServiceInitializer::class =>
                new AuthenticationServiceInitializer
        ]
    ],

    \MSBios\Voting\Module::class => [

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\VoteResolver
         */
        'vote_resolver' => VoteResolver::class,

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\VoteRepositoryResolver::class => -100
         * ]
         */
        'vote_resolvers' => [
            // Resolver\VoteRepositoryResolver::class => -100,
            // Resolver\VoteCookieResolver::class => -120,
        ],

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\CheckRepositoryResolver::class => -100
         * ]
         */
        'check_resolvers' => [
            // Resolver\CheckRepositoryResolver::class => -100,
            // Resolver\CheckCookieResolver::class => -120,
        ]
    ]
];
