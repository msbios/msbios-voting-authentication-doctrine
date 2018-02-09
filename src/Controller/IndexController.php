<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Controller;

use MSBios\Authentication\AuthenticationServiceAwareInterface;
use MSBios\Authentication\AuthenticationServiceAwareTrait;
use MSBios\Voting\Doctrine\Controller\IndexController as DefaultIndexController;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\Plugin\Redirect;

/**
 * Class IndexController
 * @package MSBios\Voting\Authentication\Doctrine\Controller
 */
class IndexController extends DefaultIndexController implements AuthenticationServiceAwareInterface
{
    use AuthenticationServiceAwareTrait;

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
}
