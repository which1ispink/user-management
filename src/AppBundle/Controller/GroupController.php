<?php
namespace AppBundle\Controller;

use AppBundle\Exception\EntityNotFoundException;
use AppBundle\Exception\InvalidInputDataException;
use AppBundle\Exception\InvalidOperationException;
use AppBundle\Service\GroupService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupController
 */
class GroupController extends RestController
{
    /**
     * List all groups
     *
     * @Route("/api/group")
     * @Method({"GET","HEAD"})
     */
    public function listAction()
    {
        $groups = $this->getGroupService()->findAll();
        return $this->jsonSerializeResponse($groups);
    }

    /**
     * Create group
     *
     * @Route("/api/group")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        try {
            $name = $request->request->get('name');
            $createdGroup = $this->getGroupService()->create($name);
            // returning the created resource instead of sending a location header
            return $this->jsonSerializeResponse($createdGroup, 201);
        } catch (InvalidInputDataException $e) {
            $message = ['message' => $e->getMessage()];
            return $this->jsonSerializeResponse($message, 400);
        }
    }

    /**
     * Delete group
     *
     * @Route("/api/group/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        try {
            $this->getGroupService()->delete($id);
            $message = ['message' => 'Group has been deleted'];
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
     * @return GroupService
     */
    private function getGroupService()
    {
        return $this->container->get('group_service');
    }
}
