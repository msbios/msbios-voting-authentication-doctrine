<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Resolver;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Voting\Authentication\Doctrine\Exception;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use Zend\Authentication\AuthenticationServiceInterface;

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
     * @return string
     */
    protected function hash(PollInterface $poll, $relation = null)
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();
        if (!$authenticationService->hasIdentity()) {
            new Exception('You must have identity for hash value');
        }

        return md5(
            $poll->getId() . md5(
                $relation . md5($authenticationService->getIdentity()->getId())
            )
        );
    }
}
