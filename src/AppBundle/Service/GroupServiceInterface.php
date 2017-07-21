<?php
namespace AppBundle\Service;

use AppBundle\Entity\Group;

/**
 * Interface GroupServiceInterface
 */
interface GroupServiceInterface extends ApplicationServiceInterface
{
    /**
     * Creates a new group given the group name
     *
     * @param string $name
     * @return Group
     */
    public function create($name);
}
