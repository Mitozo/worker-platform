<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\UpdateFieldTrait;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
class Treatment
{
    use UpdateFieldTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $contentAnswer = [];

    #[ORM\Column(length: 10)]
    private ?string $workerRegNumber = null;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentAnswer(): array
    {
        return $this->contentAnswer;
    }

    public function setContentAnswer(array $contentAnswer): static
    {
        $this->contentAnswer = $contentAnswer;

        return $this;
    }

    public function getWorkerRegNumber(): ?string
    {
        return $this->workerRegNumber;
    }

    public function setWorkerRegNumber(string $workerRegNumber = "REG-DEV-001"): static
    {
        $this->workerRegNumber = $workerRegNumber;

        return $this;
    }
}
