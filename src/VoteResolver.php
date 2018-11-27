<?php
///**
// * @access protected
// * @author Judzhin Miles <info[woof-woof]msbios.com>
// */
//
//namespace MSBios\Voting\Authentication\Doctrine;
//
//use MSBios\Voting\Authentication\Doctrine\Resolver\VoteInterface;
//use MSBios\Voting\Doctrine\VoteResolver as DefaultVoteResolver;
//use MSBios\Voting\Resource\Record\PollInterface;
//
///**
// * Class VoteResolver
// * @package MSBios\Voting\Authentication\Doctrine
// */
//class VoteResolver extends DefaultVoteResolver implements VoteResolverInterface
//{
//    /**
//     * @param PollInterface $poll
//     * @return mixed
//     */
//    public function find(PollInterface $poll)
//    {
//        if (count($this->queue)) {
//            /** @var VoteInterface $resolver */
//            foreach ($this->queue as $resolver) {
//                if ($resolver instanceof VoteInterface) {
//                    if ($resource = $resolver->find($poll)) {
//                        return $resource;
//                    }
//                }
//            }
//        }
//    }
//}
