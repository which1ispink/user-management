<?php
namespace AppBundle\Service;

use AppBundle\Exception\InvalidOperationException;

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
     * @throws InvalidOperationException if the user or group identified by the IDs don't exist
     */
    public function assignToGroup($userId, $groupId);

    /**
     * Removes the user identified by $userId from the group identified by $groupId
     *
     * @param int $userId
     * @param int $groupId
     * @throws InvalidOperationException if the user or group identified by the IDs don't exist
     */
    public function removeFromGroup($userId, $groupId);
}
