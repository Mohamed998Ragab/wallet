<?php

namespace Modules\WithdrawRequest\Exceptions;

use Exception;

class SelfApprovalException extends Exception
{
    protected $message = 'You cannot approve your own withdrawal request';
}