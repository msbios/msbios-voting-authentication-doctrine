<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Controller;

use MSBios\Voting\Doctrine\Controller\IndexController as DefaultIndexController;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class IndexController
 * @package MSBios\Voting\Authentication\Doctrine\Controller
 */
class IndexController extends DefaultIndexController  // AbstractActionController
{
//    /**
//     * @return \Zend\Http\Response
//     */
//    public function voteAction()
//    {
//        if ($this->poll()->setData($this->params()->fromPost())->vote()) {
//            $this->flashMessenger()->addSuccessMessage('Your voice has been accepted and processed.');
//        }
//        return $this->redirect()->toRoute('home');
//    }
//
//    /**
//     * @return \Zend\Http\Response
//     */
//    public function undoAction()
//    {
//        $this->poll()->undo(
//            $this->params()->fromRoute('option_id'),
//            $this->params()->fromRoute('relation')
//        );
//        $this->flashMessenger()->addInfoMessage('The selected voice was canceled.');
//        return $this->redirect()->toRoute('home');
//    }
}
