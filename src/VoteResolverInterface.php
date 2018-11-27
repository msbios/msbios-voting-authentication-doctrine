<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Authentication\Doctrine;

use MSBios\Voting\Authentication\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Doctrine\VoteResolverInterface as DefaultVoteResolverInterface;

/**
 * Interface VoteResolverInterface
 * @package MSBios\Voting\Authentication\Doctrine
 */
interface VoteResolverInterface extends DefaultVoteResolverInterface, VoteInterface
{
    // ...
}