<?php

namespace App\Filter;

class MovieFilter
{
    public ?string $prompt = null;
    public array $categories = [];
    public array $services = [];
    public ?bool $isRated18 = null;
    public ?int $yearAfter = null;
    public ?int $yearBefore = null;
    public ?string $country = null;
    public ?int $minScore = null;
    public ?int $maxScore = null;

    public function __construct(
        ?string $prompt = null,
        array $categories = [],
        array $services = [],
        ?bool $isRated18 = null,
        ?int $yearAfter = null,
        ?int $yearBefore = null,
        ?string $country = null,
        ?int $minScore = null,
        ?int $maxScore = null,
    ) {
        $this->prompt = $prompt;
        $this->categories = $categories;
        $this->services = $services;
        $this->isRated18 = $isRated18;
        $this->yearAfter = $yearAfter;
        $this->yearBefore = $yearBefore;
        $this->country = $country;
        $this->minScore = $minScore;
        $this->maxScore = $maxScore;
    }
}
