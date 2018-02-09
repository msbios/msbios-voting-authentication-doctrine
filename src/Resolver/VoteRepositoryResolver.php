<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity;
use MSBios\Voting\Resource\Entity\Vote;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class VoteRepositoryResolver implements
    VoteInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     * @return EntityInterface|Entity\Vote
     */
    protected function find(Entity\OptionInterface $option, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        if (empty($relation)) {

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(Entity\Vote::class);

            /** @var EntityInterface $vote */
            $vote = $repository->findOneBy(['option' => $option]);

            if (! $vote) {

                /** @var EntityInterface $vote */
                $vote = new Entity\Vote;
                $vote->setPoll($option->getPoll())
                    ->setOption($option)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setModifiedAt(new \DateTime('now'));

                $dem->persist($vote);
                $dem->flush();
            }
        } else {

            /** @var EntityInterface $poll */
            $poll = $dem->getRepository(Entity\Poll\Relation::class)->findOneBy([
                'code' => $relation
            ]);

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(Entity\Vote\Relation::class);

            /** @var EntityInterface $vote */
            $vote = $repository->findOneBy([
                'poll' => $poll,
                'option' => $option
            ]);

            if (! $vote) {
                /** @var EntityInterface $vote */
                $vote = new Entity\Vote\Relation;
                $vote->setPoll($poll)
                    ->setOption($option)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setModifiedAt(new \DateTime('now'));

                $dem->persist($vote);
                $dem->flush();
            }
        }

        return $vote;
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function vote(Entity\OptionInterface $option, $relation = null)
    {
        /** @var Vote $vote */
        $vote = $this->find($option, $relation);
        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime('now'));

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        $dem->merge($vote);
        $dem->flush();
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function undo(Entity\OptionInterface $option, $relation = null)
    {
        /** @var Vote $vote */
        $vote = $this->find($option, $relation);

        if ($vote->getTotal()) {
            $vote->setTotal($vote->getTotal() - 1)
                ->setModifiedAt(new \DateTime('now'));

            /** @var ObjectManager $dem */
            $dem = $this->getObjectManager();
            $dem->merge($vote);
            $dem->flush();
        }
    }
}
