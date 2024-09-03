<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
    const ADMIN = 'Admin';
    const DESIGNER = 'Designer';
    const PRINTING = 'Printing';
    const PROCESSOR = 'Processor';
    const ACCOUNTANT = 'Accountant';
}
