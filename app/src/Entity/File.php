<?php

namespace App\Entity;

use App\Repository\FileRepository;
use App\Traits\UpdateFieldTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    use UpdateFieldTrait;

    const IMPORTED = 0;
    const MAPPED = 1;
    const PRODUCTION = 2;
    const STATUS_TYPE = [self::IMPORTED, self::MAPPED, self::PRODUCTION];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\Column(length: 10)]
    private ?string $project_ref = null;

    #[ORM\Column]
    private ?int $status = null;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getProjectRef(): ?string
    {
        return $this->project_ref;
    }

    public function setProjectRef(string $project_ref): static
    {
        $this->project_ref = $project_ref;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $allowedStatus = self::STATUS_TYPE;
        if (!in_array($status, $allowedStatus)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }
        $this->status = $status;

        return $this;
    }
}
