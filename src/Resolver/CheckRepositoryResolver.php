<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\UserRelation;
use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class CheckRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class CheckRepositoryResolver implements CheckInterface, ObjectManagerAwareInterface, AuthenticationServiceAwareInterface
{
    use ProvidesObjectManager;
    use AuthenticationServiceAwareTrait;

    /**
     * CheckRepositoryResolver constructor.
     * @param ObjectManager $objectManager
     *
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(ObjectManager $objectManager, AuthenticationServiceInterface $authenticationService)
    {
        $this->setObjectManager($objectManager);
        $this->setAuthenticationService($authenticationService);
    }

    /**
     * @param PollInterface $poll
     * @return bool|mixed
     */
    public function check(PollInterface $poll)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();

        if (!$authenticationService->hasIdentity()) {
            return false;
        }

        /** @var ObjectRepository $repository */
        $repository = $this
            ->getObjectManager()
            ->getRepository($poll instanceof RelationInterface ? UserRelation::class : User::class);

        /** @var EntityInterface $entity */
        $entity = $repository->findByPollAndIdentity($poll, $authenticationService->getIdentity());
        return $entity instanceof EntityInterface;
    }
}
