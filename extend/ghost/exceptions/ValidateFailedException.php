<?php
declare(strict_types=1);

namespace ghost\exceptions;

use ghost\Code;

class ValidateFailedException extends GhostException
{
    protected $code = Code::VALIDATE_FAILED;
}
