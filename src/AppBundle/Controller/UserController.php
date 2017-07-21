<?php
namespace AppBundle\Controller;

use AppBundle\Exception\EntityNotFoundException;
use AppBundle\Exception\InvalidOperationException;
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
     * Create user
     *
     * @Route("/api/user")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        try {
            $name = $request->request->get('name');
            $createdUser = $this->getUserService()->create($name);
            // returning the created resource instead of sending a location header
            return $this->jsonSerializeResponse($createdUser, 201);
        } catch (InvalidInputDataException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 400);
        }
    }

    /**
     * Delete user
     *
     * @Route("/api/user/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        try {
            $this->getUserService()->delete($id);
            $message = ['message' => 'User has been deleted'];
            return $this->jsonSerializeResponse($message);
        } catch (EntityNotFoundException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 404);
        }
    }

    /**
     * Assign user to group
     *
     * @Route("/api/user/{userId}/group/{groupId}")
     * @Method({"POST"})
     */
    public function assignToGroupAction($userId, $groupId)
    {
        try {
            $this->getUserService()->assignToGroup($userId, $groupId);
            $message = ['message' => 'User has been assigned to group'];
            return $this->jsonSerializeResponse($message);
        } catch (EntityNotFoundException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 404);
        } catch (InvalidOperationException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 400);
        }
    }

    /**
     * Remove user from group
     *
     * @Route("/api/user/{userId}/group/{groupId}")
     * @Method({"DELETE"})
     */
    public function removeFromGroupAction($userId, $groupId)
    {
        try {
            $this->getUserService()->removeFromGroup($userId, $groupId);
            $message = ['message' => 'User has been removed from group'];
            return $this->jsonSerializeResponse($message);
        } catch (EntityNotFoundException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 404);
        } catch (InvalidOperationException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 400);
        }
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->container->get('user_service');
    }
}
