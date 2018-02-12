<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Authentication\IdentityInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Guard\Resource\UserInterface;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User\Relation;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Doctrine\Resolver\VoteRepositoryResolver as DefaultVoteRepositoryResolver;
use MSBios\Voting\Resource\Doctrine\Entity;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class VoteRepositoryResolver extends DefaultVoteRepositoryResolver implements
    VoteInterface,
    ObjectManagerAwareInterface,
    AuthenticationServiceAwareInterface
{
    use ObjectManagerAwareTrait;
    use AuthenticationServiceAwareTrait;

    /**
     * @param Entity\VoteInterface $vote
     * @param IdentityInterface $identity
     * @param null $relation
     * @return null|object
     */
    protected function resolve(Entity\VoteInterface $vote, IdentityInterface $identity, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var ObjectRepository $repository */
        $repository = empty(! $relation)
            ? $dem->getRepository(Relation::class)
            : $dem->getRepository(User::class);

        return $repository->findOneBy([
            'vote' => $vote,
            'user' => $identity
        ]);
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function vote(Entity\OptionInterface $option, $relation = null)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if ($authenticationService->hasIdentity()) {

            /** @var Entity\VoteInterface $vote */
            $vote = $this->find($option, $relation);

            /** @var IdentityInterface|UserInterface $identity */
            $identity = $authenticationService->getIdentity();

            /** @var EntityInterface $result */
            if (! $result = $this->resolve($vote, $identity, $relation)) {

                /** @var ObjectManager $dem */
                $dem = $this->getObjectManager();

                /** @var EntityInterface $entity */
                $entity = (! empty($relation)) ? new Relation : new User;

                $entity->setVote($vote)
                    ->setUser($identity)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setModifiedAt(new \DateTime('now'));

                $dem->persist($entity);
                $dem->flush();
            }
        };
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function undo(Entity\OptionInterface $option, $relation = null)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if ($authenticationService->hasIdentity()) {

            /** @var Entity\VoteInterface $vote */
            $vote = $this->find($option, $relation);

            /** @var IdentityInterface $identity */
            $identity = $authenticationService->getIdentity();

            /** @var EntityInterface $entity */
            if ($entity = $this->resolve($vote, $identity, $relation)) {
                /** @var ObjectManager $dem */
                $dem = $this->getObjectManager();
                $dem->remove($entity);
                $dem->flush();
            }
        };
    }
}
