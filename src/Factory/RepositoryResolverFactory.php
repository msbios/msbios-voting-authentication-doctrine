<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Authentication\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Voting\Authentication\Doctrine\Resolver\CheckRepositoryResolver;
use MSBios\Voting\Authentication\Doctrine\Resolver\VoteRepositoryResolver;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RepositoryResolverFactory
 * @package MSBios\Voting\Authentication\Doctrine\Factory
 */
class RepositoryResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return mixed|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(EntityManager::class),
            $container->get(AuthenticationService::class)
        );
    }
}
