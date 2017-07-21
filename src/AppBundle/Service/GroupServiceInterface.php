<?php
namespace AppBundle\Service;

/**
 * Interface GroupServiceInterface
 */
interface GroupServiceInterface extends ApplicationServiceInterface
{
    /**
     * Creates a new group given the group name
     *
     * @param string $name
     */
    public function create($name);
}
