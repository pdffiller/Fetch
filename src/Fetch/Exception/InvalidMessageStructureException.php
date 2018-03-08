<?php

namespace Fetch\Exception;

use Throwable;

class InvalidMessageStructureException extends \RuntimeException
{
    protected $uid;

    public function __construct($uid, Throwable $previous = null)
    {
        $message = 'Unable to obtain message structure or structure is invalid';
        $this->uid = $uid;

        parent::__construct($message, 0, $previous);
    }

    public function getUid()
    {
        return $this->uid;
    }
}