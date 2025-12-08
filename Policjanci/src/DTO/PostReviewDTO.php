<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PostReviewDTO
{
    #[Assert\Length(
        max: 50,
        maxMessage: 'Username cannot be longer than {{ limit }} characters.'
    )]
    public ?string $author = null;

    #[Assert\Length(
        max: 250,
        maxMessage: 'Comment cannot be longer than {{ limit }} characters.'
    )]
    public ?string $comment = null;

    #[Assert\NotNull(message: 'Please specify if the review is positive or not.')]
    #[Assert\Type('bool')]
    public ?bool $positive = null;
}
