<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'status' => LoanStatus::class,
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class)->withTrashed();
    }
}
