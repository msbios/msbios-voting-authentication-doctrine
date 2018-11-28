<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Authentication\Doctrine\Controller;

use MSBios\Guard\GuardInterface;
use MSBios\Voting\Doctrine\Controller\IndexController as DefaultIndexController;
use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Class IndexController
 * @package MSBios\Voting\Authentication\Doctrine\Controller
 */
class IndexController extends DefaultIndexController implements
    GuardInterface,
    ResourceInterface
{
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getResourceId()
    {
        return self::class;
    }
}
