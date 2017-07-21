<?php
namespace AppBundle\Service;

use AppBundle\Entity\Entity;
use AppBundle\ValueObject\Paging;

interface ApplicationServiceInterface
{
    /**
     * Finds an entity given its ID
     *
     * @param int $id
     * @return Entity|null
     */
    public function find($id);

    /**
     * Returns an array of entities matching the given optional parameters
     *
     * @param array $filters
     * @param array|null $orderBy
     * @param Paging|null $paging
     * @return array
     */
    public function findAll(array $filters = [], array $orderBy = null, Paging $paging = null);

    /**
     * Deletes an entity given its ID
     *
     * @param $id
     */
    public function delete($id);
}
