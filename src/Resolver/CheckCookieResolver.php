<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Authentication\IdentityInterface;
use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\Resource\Doctrine\Entity\RelationInterface;

/**
 * Class CheckCookieResolver
 * @package MSBios\Voting\Authentication\Doctrine\Resolver
 */
class CheckCookieResolver implements CheckInterface, AuthenticationServiceAwareInterface
{
    use AuthenticationServiceAwareTrait;

    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        if (!$this->getAuthenticationService()->hasIdentity()) {
            return false;
        }

        /** @var IdentityInterface $identity */
        $identity = $this->getAuthenticationService()->getIdentity();

        /** @var string $relation */
        $relation = '';

        if ($poll instanceof RelationInterface) {
            $relation = $poll->getCode();
        }

        /** @var string $key */
        $key = md5(
            $poll->getId() . md5(
                $relation . md5($this->getAuthenticationService()->getIdentity()->getId())
            )
        );

        return array_key_exists($key, $_COOKIE);
    }
}
