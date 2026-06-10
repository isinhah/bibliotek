<?php

namespace App\DTOs;

final readonly class FilterUserLoanDTO
{
    public function __construct(
        public ?string $status = null,
        public ?string $search = null,
        public int $perPage = 15
    ) {}
}
