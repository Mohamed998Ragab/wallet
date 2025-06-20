<?php
namespace Modules\Wallet\Exceptions;

use Exception;

class InsufficientHeldBalanceException extends Exception
{
    protected $message = 'Insufficient held balance';
}
