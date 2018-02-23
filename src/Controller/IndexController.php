<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Controller;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Controller\IndexController as DefaultIndexController;
use MSBios\Voting\PollManagerAwareInterface;
use MSBios\Voting\PollManagerAwareTrait;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\VoteManagerAwareInterface;
use MSBios\Voting\VoteManagerAwareTrait;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\Plugin\Redirect;

/**
 * Class IndexController
 * @package MSBios\Voting\Authentication\Doctrine\Controller
 */
class IndexController extends DefaultIndexController implements
    AuthenticationServiceAwareInterface,
    PollManagerAwareInterface,
    VoteManagerAwareInterface
{
    use AuthenticationServiceAwareTrait;
    use PollManagerAwareTrait;
    use VoteManagerAwareTrait;

    /**
     * @return \Zend\Http\Response
     */
    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {

            /** @var ValidatableAdapterInterface $adapter */
            $adapter = $this->getAuthenticationService()->getAdapter();

            /** @var array $params */
            $params = $this->params()->fromPost();

            $adapter->setIdentity($params['username']);
            $adapter->setCredential($params['password']);

            /** @var Result $authenticationResult */
            $authenticationResult = $this->authenticationService->authenticate();

            if ($authenticationResult->isValid()) {

                /** @var Redirect $redirect */
                $redirect = $this->redirect();

                if (! empty($params['redirect'])) {
                    return $redirect->toUrl(base64_decode($params['redirect']));
                }

                return $redirect->toRoute('home');
            }
        }
    }

    /**
     * @return \Zend\Http\Response
     */
    public function undoAction()
    {
        /** @var PollInterface $poll */
        $poll = $this->getPollManager()->find(
            $this->params()->fromRoute('poll_id'),
            $this->params()->fromRoute('relation')
        );

        /** @var EntityInterface $vote */
        $vote = $this->getVoteManager()->find($poll);

        $this->poll()->undo(
            $vote->getVote()->getOption()->getId(),
            $this->params()->fromRoute('relation')
        );
        $this->flashMessenger()->addInfoMessage('The selected voice was canceled.');
        return $this->redirect()->toRoute('home');
    }
}
