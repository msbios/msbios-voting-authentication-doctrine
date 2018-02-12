<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Record\OptionInterface;

/**
 * Class VoteCookieResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class VoteCookieResolver extends AbstractCookieResolver implements
    VoteInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function vote(OptionInterface $option, $relation = null)
    {
        if ($this->getAuthenticationService()->hasIdentity()) {
            /** @var string $key */
            $key = $this->hash($option->getPoll(), $relation);
            setcookie($key, 1, time() + 60 * 60 * 24 * 365);
        }
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function undo(OptionInterface $option, $relation = null)
    {
        if ($this->getAuthenticationService()->hasIdentity()) {
            /** @var string $key */
            $key = $this->hash($option->getPoll(), $relation);
            if (isset($_COOKIE[$key])) {
                unset($_COOKIE[$key]);
                setcookie($key, null, -1);
            }
        }
    }
}
