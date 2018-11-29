<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Authentication\IdentityInterface;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\UserRelation;
use MSBios\Voting\Doctrine\Provider\VoteProviderInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class VoteProvider
 * @package MSBios\Voting\Authentication\Doctrine\Provider
 */
class VoteProvider implements
    VoteProviderInterface,
    ObjectManagerAwareInterface,
    AuthenticationServiceAwareInterface
{
    use ProvidesObjectManager;
    use AuthenticationServiceAwareTrait;

    /**
     * VoteProvider constructor.
     * @param ObjectManager $objectManager
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(ObjectManager $objectManager, AuthenticationServiceInterface $authenticationService)
    {
        $this->setObjectManager($objectManager);
        $this->setAuthenticationService($authenticationService);
    }

    /**
     * @param PollInterface $poll
     * @return mixed|void
     */
    public function find(PollInterface $poll)
    {

        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();

        if (! $authenticationService->hasIdentity()) {
            return;
        }

        /** @var IdentityInterface $identity */
        $identity = $authenticationService->getIdentity();

        if ($poll instanceof RelationInterface) {
            /** @var ObjectRepository $repository */
            $repository = $this
                ->getObjectManager()
                ->getRepository(UserRelation::class);

            /** @var UserRelation $userRelation */
            $userRelation = $repository->findOneByPollAndIdentity($poll, $identity);

            return $userRelation
                ->getVote()
                ->getOption();
        }

        /** @var ObjectRepository $repository */
        $repository = $this
            ->getObjectManager()
            ->getRepository(User::class);

        /** @var User $user */
        $user = $repository
            ->findOneByPollAndIdentity($poll, $identity);

        return $user
            ->getVote()
            ->getOption();
    }
}
