<?php
namespace AppBundle\Service;

use AppBundle\Entity\Group;
use AppBundle\Exception\EntityNotFoundException;
use AppBundle\Exception\InvalidOperationException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class GroupService
 *
 * Groups application service
 */
class GroupService extends AbstractService implements GroupServiceInterface
{
    /**
     * GroupService constructor
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @inheritdoc
     */
    public function create($name)
    {
        $group = new Group();
        $group->setName($name);

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return $group;
    }

    /**
     * @inheritdoc
     * @throws InvalidOperationException if the group has assigned users
     */
    public function delete($id)
    {
        /** @var Group $group */
        $group = $this->find($id);
        if (! $group) {
            throw new EntityNotFoundException(
                'The specified group can not be found'
            );
        }

        if ($group->hasAssignedUsers()) {
            throw new InvalidOperationException(
                'The specified group has assigned users and can not be deleted'
            );
        }

        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    protected function getEntityClass()
    {
        return Group::class;
    }
}
