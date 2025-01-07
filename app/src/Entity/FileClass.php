<?php

namespace App\Entity;

use App\Repository\FileClassRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileClassRepository::class)]
class FileClass
{
    const ACTIVITY_TYPE = ['PRODUCTION', 'CORRECTION', 'TEST', 'FORMATION'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", columnDefinition: "ENUM('PRODUCTION', 'CORRECTION', 'TEST', 'FORMATION')")]
    private ?string $type = null;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $allowedValues = self::ACTIVITY_TYPE;
        if (!in_array(strtoupper($type), $allowedValues, true)) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }
        $this->type = $type;

        return $this;
    }
}
