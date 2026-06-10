<?php

namespace App\DTOs;

final readonly class CreateLoanDTO
{
    public function __construct(
        public int $bookId,
        public int $userId
    ) {}
}
