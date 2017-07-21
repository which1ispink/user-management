<?php
namespace AppBundle\Exception;

use RuntimeException;

/**
 * Class InvalidInputDataException
 *
 * Should be thrown when there's invalid input data for entity creation/manipulation
 */
class InvalidInputDataException extends RuntimeException implements ExceptionInterface
{
}
