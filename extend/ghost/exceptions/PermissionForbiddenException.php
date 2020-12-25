<?php
declare(strict_types=1);

namespace ghost\exceptions;

use ghost\Code;

class PermissionForbiddenException extends GhostException
{
    protected $code = Code::PERMISSION_FORBIDDEN;

    protected $message = 'permission forbidden';
}
