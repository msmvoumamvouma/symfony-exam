<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([GroupName::FILTERABLE])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([GroupName::READ, GroupName::WRITE, GroupName::FILTERABLE])]
    #[Assert\NotNull(groups: [GroupName::WRITE, GroupName::FILTERABLE])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([GroupName::READ, GroupName::WRITE, GroupName::FILTERABLE])]
    #[Assert\NotNull(groups: [GroupName::WRITE, GroupName::FILTERABLE])]
    private ?string $firstName = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class, cascade: ['persist'])]
    #[Groups([GroupName::WRITE, GroupName::READ, GroupName::FILTERABLE])]
    #[Assert\Count(
        min: 1,
        minMessage: 'You must specify at least one book',
        groups: [GroupName::WRITE]
    )]
    /**
     * @var Collection<Book>
     */
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBooks(): ?Collection
    {
        return $this->books;
    }

    public function setBooks(?Collection $books): self
    {
        $this->books = $books;

        return $this;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $book->setAuthor($this);
            $this->books->add($book);
        }

        return $this;
    }

    #[Groups([GroupName::FILTERABLE])]
    public function getNumberOfBook(): int
    {
        return $this->books->count();
    }
}
