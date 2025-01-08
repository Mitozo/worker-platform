<?php

namespace App\Entity;

use App\Repository\FileDetailsRepository;
use App\Traits\UpdateFieldTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileDetailsRepository::class)]
class FileDetails
{
    use UpdateFieldTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $extension = null;

    #[ORM\Column(nullable: true)]
    private ?array $sheets_name = null;

    #[ORM\Column]
    private array $header = [];

    #[ORM\Column(length: 255)]
    private ?string $uuidKey = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getSheetsName(): ?array
    {
        return $this->sheets_name;
    }

    public function setSheetsName(?array $sheets_name): static
    {
        $this->sheets_name = $sheets_name;

        return $this;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getUuidKey(): ?string
    {
        return $this->uuidKey;
    }

    public function setUuidKey(string $uuidKey): static
    {
        $this->uuidKey = $uuidKey;

        return $this;
    }
}
