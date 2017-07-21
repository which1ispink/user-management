<?php
namespace AppBundle\Controller;

use AppBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 */
class UserController extends RestController
{
    /**
     * Returns a list of all users
     *
     * @Route("/api/user")
     * @Method({"GET","HEAD"})
     */
    public function listAction()
    {
        $users = $this->getUserService()->findAll();
        return $this->jsonSerializeResponse($users);
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->container->get('user_service');
    }
}
