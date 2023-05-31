<?php

namespace App\Enums;

use Spatie\Enum\Enum;

final class DispatchStatusEnum extends Enum
{
    const NEW_TICKET = 'New Ticket';
    const TICKET_PRINTED = 'Ticket Printed';
    const COMPLETE = 'Completed';
    const CANCELLED = 'Cancelled';
}
