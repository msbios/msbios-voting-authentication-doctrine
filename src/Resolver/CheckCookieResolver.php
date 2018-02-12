<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\Resource\Doctrine\Entity\RelationInterface;

/**
 * Class CheckCookieResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class CheckCookieResolver extends AbstractCookieResolver  implements CheckInterface
{

    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        if (! $this->getAuthenticationService()->hasIdentity()) {
            return false;
        }

        /** @var string $relation */
        $relation = '';

        if ($poll instanceof RelationInterface) {
            $relation = $poll->getCode();
        }

        /** @var string $key */
        $key = $this->hash($poll, $relation);

        return array_key_exists($key, $_COOKIE);
    }
}
