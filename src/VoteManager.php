<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine;

use MSBios\Voting\Authentication\IdentityResolverInterface;
use MSBios\Voting\Doctrine\VoteManager as DefaultVoteManager;
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
     * @param PollInterface $poll
     * @return mixed
     */
    public function find(PollInterface $poll)
    {
        return $this->voteResolver->find($poll);
    }
}
