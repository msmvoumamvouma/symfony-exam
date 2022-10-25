<?php

namespace App\Response;

use App\Entity\GroupName;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

class SaveAuthorResponse
{
    #[Groups([GroupName::READ, GroupName::READ])]
    private ?ErrorResponse $error;

    #[Groups([GroupName::READ, GroupName::READ])]
    private mixed $data;

    public function __construct(mixed $data, ErrorResponse $errorResponse = null)
    {
        $this->error = $errorResponse;

        $this->data = $data;
    }

    public function getError(): ?ErrorResponse
    {
        return $this->error;
    }

    public function setError(?ErrorResponse $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }

    #[Ignore]
    public function getErrorCode(): int
    {
        return $this->error?->getErrorCode() ?? 200;
    }
}
