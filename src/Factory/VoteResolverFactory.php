<?php
///**
// * @access protected
// * @author Judzhin Miles <info[woof-woof]msbios.com>
// */
//namespace MSBios\Voting\Authentication\Doctrine\Factory;
//
//use Interop\Container\ContainerInterface;
//use MSBios\Voting\Authentication\Doctrine\VoteResolver;
//use MSBios\Voting\Authentication\Doctrine\VoteResolverInterface;
//use MSBios\Voting\Authentication\Exception\ResolverServiceNotFoundException;
//use MSBios\Voting\Module;
//use Zend\ServiceManager\Factory\FactoryInterface;
//
///**
// * Class VoteResolverFactory
// * @package MSBios\Voting\Authentication\Doctrine\Factory
// */
//class VoteResolverFactory implements FactoryInterface
//{
//
//    /**
//     * @param ContainerInterface $container
//     * @param string $requestedName
//     * @param array|null $options
//     * @return VoteResolver|VoteResolverInterface
//     */
//    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
//    {
//        /** @var VoteResolverInterface $resolverManager */
//        $resolverManager = new VoteResolver;
//
//        /** @var array $options */
//        $options = $container->get(Module::class);
//
//        /**
//         * @var string $resolver
//         * @var int $priority
//         */
//        foreach ($options['vote_resolvers'] as $resolver => $priority) {
//            if (! $container->has($resolver)) {
//                throw new ResolverServiceNotFoundException(
//                    "Resolver '{$resolver}' Service is not found in Service Locator."
//                );
//            }
//            $resolverManager->attach($container->get($resolver), $priority);
//        }
//
//        return $resolverManager;
//    }
//}
