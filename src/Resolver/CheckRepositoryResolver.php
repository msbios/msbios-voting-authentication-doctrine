<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\Relation;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\Resource\Doctrine\Entity\RelationInterface;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class CheckRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class CheckRepositoryResolver implements CheckInterface,
    ObjectManagerAwareInterface,
    AuthenticationServiceAwareInterface
{
    use ObjectManagerAwareTrait;
    use AuthenticationServiceAwareTrait;

    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();

        if (!$authenticationService->hasIdentity()) {
            return false;
        }

        return $this->getObjectManager()
            ->getRepository(($poll instanceof RelationInterface) ? Relation::class : User::class)
            ->findByPollAndIdentity($poll, $authenticationService->getIdentity()) ? true : false;

    }
}
