<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class StageType extends Enum
{
    const INQUIRY = '1';
    const DESIGN = '2';
    const PRINT = '3';
    const BILLING = '4';
    const COMPLETED = '5';

}
