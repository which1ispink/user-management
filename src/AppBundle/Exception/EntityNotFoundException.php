<?php
namespace AppBundle\Exception;

use RuntimeException;

/**
 * Class EntityNotFoundException
 *
 * Should be thrown when an entity that does not exist is queried for
 */
class EntityNotFoundException extends RuntimeException implements ExceptionInterface
{
}
