<?php

namespace App\Enums;

enum LoanStatus: string
{
    case PENDING = 'Pending';
    case ACTIVE = 'Active';
    case RETURNED = 'Returned';
    case OVERDUE = 'Overdue';
    case CANCELLED = 'Cancelled';
}
