<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class StageType extends Enum
{
    const INQUIRY = 'Inquiry';
    const DESIGN = 'Design';
    const PRINT = 'Print';
    const DESIGNPRINT = 'Design Print';
    const BILLING = 'Billing';
}
