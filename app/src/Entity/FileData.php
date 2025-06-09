<?php

namespace App\Entity;

use App\Repository\FileDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileDataRepository::class)]
class FileData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $contentInput = [];

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentInput(): array
    {
        return $this->contentInput;
    }

    public function setContentInput(array $contentInput): static
    {
        $this->contentInput = $contentInput;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
