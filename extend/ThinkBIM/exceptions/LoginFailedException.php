<?php
declare(strict_types=1);

namespace ThinkBIM\exceptions;

use ThinkBIM\Code;

class LoginFailedException extends Exception
{
    protected $code = Code::LOGIN_FAILED;

    protected $message = 'Login Failed! Please check you email or password';
}
