<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UpdateFieldTrait
{
    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 20, options: ['default' => 'Administrator'])]
    private ?string $createdBy = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable(); // Set default to current timestamp
        }

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdby;
    }

    public function setCreatedBy(string $createdby = "Administrator"): static
    {
        $this->createdby = $createdby;

        return $this;
    }
}
