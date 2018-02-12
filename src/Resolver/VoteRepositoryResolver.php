<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Authentication\IdentityInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Guard\Resource\UserInterface;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\Relation;
use MSBios\Voting\Authentication\Resource\Doctrine\Entity\User;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Doctrine\Resolver\VoteRepositoryResolver as DefaultVoteRepositoryResolver;
use MSBios\Voting\Resource\Doctrine\Entity;
use MSBios\Voting\Resource\Record\OptionInterface;
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
     * @param EntityInterface $vote
     * @param IdentityInterface $identity
     * @param null $relation
     * @return null|object
     */
    protected function resolve(EntityInterface $vote, IdentityInterface $identity, $relation = null)
    {
        return $this->getObjectManager()
            ->getRepository(empty(!$relation) ? Relation::class : User::class)
            ->findOneBy([
                'vote' => $vote,
                'user' => $identity
            ]);
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function vote(OptionInterface $option, $relation = null)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if ($authenticationService->hasIdentity()) {

            /** @var EntityInterface $vote */
            $vote = $this->find($option, $relation);

            /** @var IdentityInterface|UserInterface $identity */
            $identity = $authenticationService->getIdentity();

            /** @var EntityInterface $result */
            if (!$result = $this->resolve($vote, $identity, $relation)) {

                /** @var ObjectManager $dem */
                $dem = $this->getObjectManager();

                /** @var EntityInterface $entity */
                $entity = (!empty($relation)) ? new Relation : new User;

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
     * @param OptionInterface $option
     * @param null $relation
     */
    public function undo(OptionInterface $option, $relation = null)
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
