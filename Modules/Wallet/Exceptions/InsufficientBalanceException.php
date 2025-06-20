<?php
namespace Modules\Wallet\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    protected $message = 'Insufficient available balance';
}
