<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Authentication\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Authentication\Doctrine\VoteManager;
use MSBios\Voting\Authentication\IdentityResolver;
use MSBios\Voting\Doctrine\Factory\VoteManagerFactory as DefaultVoteManagerFactory;
use MSBios\Voting\Module;
use Zend\Config\Config;

/**
 * Class VoteManagerFactory
 * @package MSBios\Voting\Authentication\Doctrine\Factory
 */
class VoteManagerFactory extends DefaultVoteManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Config $options */
        $options = $container->get(Module::class);

        return new VoteManager(
            $container->get(IdentityResolver::class),
            $container->get($options->get('vote_resolver')),
            $container->get($options->get('check_resolver'))
        );
    }
}