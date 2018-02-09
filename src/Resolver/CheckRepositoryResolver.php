<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Class CheckRepositoryResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class CheckRepositoryResolver implements CheckInterface
{
    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        return false;
    }
}
