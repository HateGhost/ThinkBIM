<?php
declare(strict_types=1);

namespace ThinkBIM\exceptions;


use ThinkBIM\Code;

class FailedException extends Exception
{
    protected $code = Code::FAILED;
}
