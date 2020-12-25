<?php
declare(strict_types=1);

namespace ghost\exceptions;


use ghost\Code;

class FailedException extends GhostException
{
    protected $code = Code::FAILED;
}
