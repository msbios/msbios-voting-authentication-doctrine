<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity;

/**
 * Class VoteCookieResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class VoteCookieResolver extends AbstractCookieResolver  implements
    VoteInterface,
    ObjectManagerAwareInterface,
    AuthenticationServiceAwareInterface
{
    use ObjectManagerAwareTrait;
    use AuthenticationServiceAwareTrait;

    /**
     * @param Entity\PollInterface $poll
     * @param null $relation
     * @return string
     */
    protected function hash(Entity\PollInterface $poll, $relation = null)
    {
        return md5(
            $poll->getId() . md5(
                $relation . md5($this->getAuthenticationService()->getIdentity()->getId())
            )
        );
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function vote(Entity\OptionInterface $option, $relation = null)
    {
        if ($this->getAuthenticationService()->hasIdentity()) {
            /** @var string $key */
            $key = $this->hash($option->getPoll(), $relation);
            setcookie($key, 1, time() + 60 * 60 * 24 * 365);
        }
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function undo(Entity\OptionInterface $option, $relation = null)
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
