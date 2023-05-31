<?php

namespace App\Enums;

use Spatie\Enum\Enum;

final class VehicleRequestStatusEnum extends Enum
{
    const NEW_REQUEST = 'New Request';
    const SCHEDULED = 'Scheduled';
    const CANCELLED = 'Cancelled';
}
