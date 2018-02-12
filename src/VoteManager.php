<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine;

use MSBios\Voting\Authentication\IdentityResolverInterface;
use MSBios\Voting\Doctrine\CheckResolverInterface;
use MSBios\Voting\Doctrine\VoteManager as DefaultVoteManager;
use MSBios\Voting\Doctrine\VoteResolverInterface;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Class VoteManager
 * @package MSBios\Voting\Authentication\Doctrine
 */
class VoteManager extends DefaultVoteManager
{
    /** @var IdentityResolverInterface */
    protected $identityResolver;

    /**
     * VoteManager constructor.
     * @param IdentityResolverInterface $identityResolver
     * @param VoteResolverInterface $voteResolver
     * @param CheckResolverInterface $checkResolver
     */
    public function __construct(IdentityResolverInterface $identityResolver, VoteResolverInterface $voteResolver, CheckResolverInterface $checkResolver)
    {
        $this->identityResolver = $identityResolver;
        parent::__construct($voteResolver, $checkResolver);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function find(PollInterface $poll)
    {
        return $this->identityResolver->find($poll);
    }
}