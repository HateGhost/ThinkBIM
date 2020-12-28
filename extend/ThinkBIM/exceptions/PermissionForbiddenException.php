<?php
declare(strict_types=1);

namespace ThinkBIM\exceptions;

use ThinkBIM\Code;

class PermissionForbiddenException extends Exception
{
    protected $code = Code::PERMISSION_FORBIDDEN;

    protected $message = 'permission forbidden';
}
