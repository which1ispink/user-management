<?php
namespace AppBundle\Service;

use AppBundle\Entity\Group;
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
    }

    /**
     * @inheritdoc
     */
    protected function getEntityClass()
    {
        return Group::class;
    }
}
