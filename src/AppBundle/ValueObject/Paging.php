<?php
namespace AppBundle\ValueObject;

/**
 * Class Paging
 *
 * Immutable value object to represent paging information (offset & limit)
 */
final class Paging
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $limit;

    /**
     * Constructor
     *
     * @param mixed $start
     * @param mixed $limit
     */
    public function __construct($start, $limit)
    {
        $start = (int)$start;
        $limit = (int)$limit;

        // default both to 0 if either start or limit is a negative number
        if ($start < 0 || $limit < 0) {
            $this->start = 0;
            $this->limit = 0;
        } else {
            $this->start = $start;
            $this->limit = $limit;
        }
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
