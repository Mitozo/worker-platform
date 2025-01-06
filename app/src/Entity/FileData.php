<?php

namespace App\Entity;

use App\Repository\FileDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Traits\UpdateFieldTrait;

#[ORM\Entity(repositoryClass: FileDataRepository::class)]
class FileData
{
    use UpdateFieldTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\GeneratedValue(strategy: 'NONE')] // GUID is usually generated externally
    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    #[ORM\Column]
    private array $contentInput = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContentInput(): array
    {
        return $this->contentInput;
    }

    public function setContentInput(array $contentInput): static
    {
        $this->contentInput = $contentInput;

        return $this;
    }
}
