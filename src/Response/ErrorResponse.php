<?php

namespace App\Response;

use App\Entity\GroupName;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

class ErrorResponse
{
    #[Groups([GroupName::READ, GroupName::READ])]
    private ?string $type;
    #[Groups([GroupName::READ, GroupName::READ])]
    private ?string $title;
    #[Groups([GroupName::READ, GroupName::READ])]
    private ?string $description;
    #[Ignore]
    private int $errorCode;

    public function __construct(?string $type, ?string $title, ?string $description, int $errorCode)
    {
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
        $this->errorCode = $errorCode;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
