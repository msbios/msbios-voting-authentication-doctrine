<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Class CheckCookieResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
abstract class AbstractCookieResolver implements AuthenticationServiceAwareInterface
{
    use AuthenticationServiceAwareTrait;

    /**
     * @param PollInterface $poll
     * @param null $relation
     * @return mixed
     */
    abstract protected function hash(PollInterface $poll, $relation = null);
}
