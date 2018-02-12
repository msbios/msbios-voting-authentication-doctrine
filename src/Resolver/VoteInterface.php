<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Voting\Doctrine\Resolver\VoteInterface as DefaultVoteInterface;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Interface VoteInterface
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
interface VoteInterface extends DefaultVoteInterface
{
    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function find(PollInterface $poll);
}
