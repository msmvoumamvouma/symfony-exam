<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateBookSuffix
{
    #[Assert\NotNull]
    #[Assert\Length(
        min: 2,
        minMessage: 'Your suffix must be at least {{ limit }} characters long',
    )]
    private ?string $suffix = null;

    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    public function setSuffix(?string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }
}
