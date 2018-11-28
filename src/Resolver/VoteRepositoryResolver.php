<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Authentication\IdentityInterface;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\UserRelation;
use MSBios\Voting\Doctrine\Resolver\VoteRepositoryResolver as DefaultVoteRepositoryResolver;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class VoteRepositoryResolver extends DefaultVoteRepositoryResolver implements
    ObjectManagerAwareInterface,
    AuthenticationServiceAwareInterface,
    VoteInterface
{
    use ProvidesObjectManager;
    use AuthenticationServiceAwareTrait;

    /**
     * VoteRepositoryResolver constructor.
     * @param ObjectManager $objectManager
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(ObjectManager $objectManager, AuthenticationServiceInterface $authenticationService)
    {
        parent::__construct($objectManager);
        $this->setAuthenticationService($authenticationService);
    }

    // /**
    //  * @param PollInterface $poll
    //  * @param OptionInterface $option
    //  * @return mixed|EntityInterface
    //  * @throws \Exception
    //  */
    // public function find(PollInterface $poll, OptionInterface $option)
    // {
    //     return parent::find($poll, $option);
    // }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     * @throws \Exception
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if (! $authenticationService->hasIdentity()) {
            return;
        }

        /** @var \MSBios\Voting\Resource\Record\VoteInterface $vote */
        $vote = parent::find($poll, $option);

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var IdentityInterface $identity */
        $identity = $authenticationService->getIdentity();

        if ($vote instanceof RelationInterface) {

            /** @var EntityInterface $entity */
            $entity = $dem->getRepository(UserRelation::class)->findOneBy([
                'vote' => $vote,
                'user' => $identity
            ]);

            if (! $entity) {
                parent::vote($poll, $option);

                /** @var UserRelation $entity */
                $entity = (new UserRelation)
                    ->setVote($vote)
                    ->setUser($identity)
                    ->setCreatedAt(new \DateTime)
                    ->setModifiedAt(new \DateTime);

                $dem->persist($entity);
                $dem->flush();
            }
            return;
        }

        /** @var EntityInterface $entity */
        $entity = $dem->getRepository(User::class)->findOneBy([
            'vote' => $vote,
            'user' => $identity
        ]);

        if (! $entity) {
            parent::vote($poll, $option);

            /** @var UserRelation $entity */
            $entity = (new UserRelation)
                ->setVote($vote)
                ->setUser($identity)
                ->setCreatedAt(new \DateTime)
                ->setModifiedAt(new \DateTime);

            $dem->persist($entity);
            $dem->flush();
        }

        return;
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     * @throws \Exception
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if (! $authenticationService->hasIdentity()) {
            return;
        }

        /** @var \MSBios\Voting\Resource\Record\VoteInterface $vote */
        $vote = parent::undo($poll, $option);

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var IdentityInterface $identity */
        $identity = $authenticationService->getIdentity();

        if ($vote instanceof RelationInterface) {
            /** @var EntityInterface $entity */
            $entity = $dem->getRepository(UserRelation::class)->findOneBy([
                'vote' => $vote,
                'user' => $identity
            ]);

            $dem->remove($entity);
            $dem->flush();
            return;
        }

        /** @var EntityInterface $entity */
        $entity = $dem->getRepository(User::class)->findOneBy([
            'vote' => $vote,
            'user' => $identity
        ]);

        if (! $entity) {
            $dem->remove($entity);
            $dem->flush();
        }

        return;
    }
}
