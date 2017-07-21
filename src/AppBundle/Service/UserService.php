<?php
namespace AppBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Exception\InvalidOperationException;
use AppBundle\Entity\User;

/**
 * Class UserService
 *
 * Users application service
 */
class UserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var GroupServiceInterface
     */
    private $groupService;

    /**
     * UserService constructor
     *
     * @param ObjectManager $entityManager
     * @param GroupServiceInterface $groupService
     */
    public function __construct(ObjectManager $entityManager, GroupServiceInterface $groupService)
    {
        parent::__construct($entityManager);

        $this->groupService = $groupService;
    }

    /**
     * @inheritdoc
     */
    public function create($name)
    {
        $user = new User();
        $user->setName($name);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function assignToGroup($userId, $groupId)
    {
        /** @var User $user */
        $user = $this->find($userId);
        $group = $this->groupService->find($groupId);

        if (! $user || ! $group) {
            throw new InvalidOperationException(
                'The user or group specified does not exist'
            );
        }

        $user->assignToGroup($group);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeFromGroup($userId, $groupId)
    {
        /** @var User $user */
        $user = $this->find($userId);
        $group = $this->groupService->find($groupId);
        if (! $user || ! $group) {
            throw new InvalidOperationException(
                'The user or group specified does not exist'
            );
        }

        $user->removeFromGroup($group);
        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    protected function getEntityClass()
    {
        return User::class;
    }
}
