<?php

namespace Traits;

use Doctrine\ORM\Mapping as ORM;

trait UpdateFieldTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 10)]
    private ?string $createdby = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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
