<?php
namespace AppBundle\Service;

/**
 * Interface UserServiceInterface
 */
interface UserServiceInterface extends ApplicationServiceInterface
{
    /**
     * Creates a new user given the user name
     *
     * @param string $name
     */
    public function create($name);

    /**
     * Assigns the user identified by $userId to the group identified by $groupId
     *
     * @param int $userId
     * @param int $groupId
     */
    public function assignToGroup($userId, $groupId);

    /**
     * Removes the user identified by $userId from the group identified by $groupId
     *
     * @param int $userId
     * @param int $groupId
     */
    public function removeFromGroup($userId, $groupId);
}
