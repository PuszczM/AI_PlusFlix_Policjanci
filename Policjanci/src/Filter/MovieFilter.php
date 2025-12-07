<?php

namespace App\Filter;

class MovieFilter
{
    public ?string $prompt = null;
    public array $categories = [];
    public array $services = [];
    public ?bool $isRated18 = null;
    public ?int $year = null;

    public function __construct(
        ?string $prompt = null,
        array $categories = [],
        array $services = [],
        ?bool $isRated18 = null,
        ?int $year = null
    ) {
        $this->prompt = $prompt;
        $this->categories = $categories;
        $this->services = $services;
        $this->isRated18 = $isRated18;
        $this->year = $year;
    }
}
