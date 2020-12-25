<?php
declare(strict_types=1);

namespace ghost\exceptions;

use ghost\Code;

class LoginFailedException extends GhostException
{
    protected $code = Code::LOGIN_FAILED;

    protected $message = 'Login Failed! Please check you email or password';
}
