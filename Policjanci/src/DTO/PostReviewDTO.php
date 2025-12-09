<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PostReviewDTO
{
    const AUTHOR_SIZE = 50;
    const COMMENT_SIZE = 250;

    #[Assert\Length(
        max: self::AUTHOR_SIZE,
        maxMessage: 'Username cannot be longer than {{ limit }} characters.'
    )]
    public ?string $author = null;

    #[Assert\Length(
        max: self::COMMENT_SIZE,
        maxMessage: 'Comment cannot be longer than {{ limit }} characters.'
    )]
    public ?string $comment = null;

    #[Assert\NotNull(message: 'Please specify if the review is positive or not.')]
    #[Assert\Type('bool')]
    public ?bool $positive = null;
}
