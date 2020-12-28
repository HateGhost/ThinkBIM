<?php
declare(strict_types=1);

namespace ThinkBIM\exceptions;

use ThinkBIM\Code;

class ValidateFailedException extends Exception
{
    protected $code = Code::VALIDATE_FAILED;
}
