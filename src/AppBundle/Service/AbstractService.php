<?php
namespace AppBundle\Service;

use AppBundle\Exception\EntityNotFoundException;
use AppBundle\ValueObject\Paging;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractService
 *
 * Contains the functionality common between all application services
 */
abstract class AbstractService implements ApplicationServiceInterface
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * AbstractService constructor
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findAll(array $filters = [], array $orderBy = null, Paging $paging = null)
    {
        $start = (! is_null($paging)) ? $paging->getStart() : null;
        $limit = (! is_null($paging)) ? $paging->getLimit() : null;

        return $this->getRepository()->findBy($filters, $orderBy, $limit, $start);
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        $entity = $this->find($id);
        if (! $entity) {
            throw new EntityNotFoundException(
                'Entity not found'
            );
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Returns the entity repository associated with the main entity associated with the service
     *
     * @return mixed
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository($this->getEntityClass());
    }

    /**
     * Returns the fully qualified class name for the main entity associated with the service
     *
     * @return string
     */
    abstract protected function getEntityClass();
}
