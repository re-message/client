<?php

namespace RM\Component\Client\Model;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;

/**
 * Class CodeMethod
 *
 * @package RM\Component\Client\Model
 * @author  h1karo <h1karo@outlook.com>
 */
class CodeMethod extends Enum
{
    use AutoDiscoveredValuesTrait;

    public const AUTO = 'auto';
    public const NOTIFICATION = 'notification';
    public const SMS = 'sms';
}
