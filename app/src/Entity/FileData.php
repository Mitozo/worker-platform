<?php

namespace App\Entity;

use App\Repository\FileDataRepository;
use App\Traits\UpdateFieldTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FileDataRepository::class)]
class FileData
{
    use UpdateFieldTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('input')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('input')]
    private array $contentInput = [];
    
    #[ORM\Column(type: Types::GUID)]
    #[Groups('input')]
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

    public function toArray():  array
    {
        return [
            'id' => $this->id,
            'content_input' => $this->contentInput,
            'uuid' => $this->uuid,
            'created_at' => $this->createdAt,
            'created_by' => $this->createdBy,
            'updated_at' => $this->updatedAt,
            'updated_by' => $this->updatedBy,
        ];
    }
}
