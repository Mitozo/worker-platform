<?php

namespace App\Entity;

use App\DBAL\EnumType;
use App\Repository\BatchClassRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatchClassRepository::class)]
class BatchClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'enum_batch_class')]
    private ?string $type = null;

    #[ORM\Column(length: 10)]
    private ?string $createdby = null;


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
        $allowedValues = EnumType::getValues('enum_batch_class');
        if (!in_array($type, $allowedValues, true)) {
            throw new \InvalidArgumentException("Invalid status: $type");
        }
        $this->type = $type;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdby;
    }

    public function setCreatedBy(string $createdby = "3168"): static
    {
        $this->createdby = $createdby;

        return $this;
    }
}
