<?php
namespace AppBundle\Exception;

use RuntimeException;

/**
 * Class InvalidOperationException
 *
 * Should be thrown when an invalid operation (according to the domain logic) is attempted
 */
class InvalidOperationException extends RuntimeException implements ExceptionInterface
{
}
