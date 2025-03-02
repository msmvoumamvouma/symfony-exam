<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Overblog\GraphQLBundle\Annotation as GQL;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[GQL\Type(name: 'Book')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[GQL\Field(type: 'ID')]
    #[Groups([GroupName::READ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[GQL\Field]
    #[Groups([GroupName::READ, GroupName::WRITE, GroupName::FILTERABLE])]
    #[Assert\NotNull(groups: [GroupName::WRITE])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[GQL\Field]
    #[Groups([GroupName::READ, GroupName::WRITE])]
    #[Assert\NotNull(groups: [GroupName::WRITE])]
    private ?string $resume = null;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(name: 'author_id')]
    private ?Author $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
