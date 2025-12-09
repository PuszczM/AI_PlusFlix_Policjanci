<?php

namespace App\DTO;

use App\Entity\Category;
use App\Entity\Service;
use Symfony\Component\Validator\Constraints as Assert;

class MovieDTO {

    const TITLE_SIZE = 80;
    const DESCRIPTION_SIZE = 1000;
    const COUNTRY_SIZE = 80;
    const POSTER_PATH_SIZE = 255;

    #[Assert\NotBlank(message: "Title is required.")]
    #[Assert\Length(
        max: self::TITLE_SIZE,
        maxMessage: 'Title cannot be longer than {{ limit }} characters.'
    )]
    public string $title;

    #[Assert\Length(
        max: self::DESCRIPTION_SIZE,
        maxMessage: 'Description cannot be longer than {{ limit }} characters.'
    )]
    public ?string $description = null;

    #[Assert\GreaterThan(
        value: 0,
        message: 'Release year must be a positive number.'
    )]
    #[Assert\Type('integer')]
    public int $releaseYear;

    #[Assert\NotBlank(message: "Country is required.")]
    #[Assert\Length(
        max: self::COUNTRY_SIZE,
        maxMessage: 'Country cannot be longer than {{ limit }} characters.'
    )]
    public ?string $country;

    #[Assert\NotNull(message: 'Please specify if the movie is series or not.')]
    #[Assert\Type('bool')]
    public ?bool $isSeries = false;

    #[Assert\Length(
        max: self::POSTER_PATH_SIZE,
        maxMessage: 'Poster path cannot be longer than {{ limit }} characters.'
    )]
    public ?string $posterPath = null;

    #[Assert\NotNull(message: 'Please specify if the movie is rated 18+ or not.')]
    #[Assert\Type('bool')]
    public bool $isAdult = false;

    /** @var Category[] */
    public array $categories = [];

    /** @var Service[] */
    public array $services = [];
}
