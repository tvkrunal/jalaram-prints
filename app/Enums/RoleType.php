<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
    const ADMINISTRATOR = 'Administrator';
    const ADMIN = 'Admin';
    const HR = 'HR';
    const PROJECT_MANAGER = 'Project Manager';
    const TEAM_LEADER = 'Team Leader';
    const EMPLOYEE = 'Employee';
    const MARKETING = 'Marketing';
}
