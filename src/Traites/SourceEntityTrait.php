<?php

namespace App\Traites;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait SourceEntityTrait
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sourceId = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $sourceCreatedAt = null;

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }

    public function setSourceId(?string $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getSourceCreatedAt(): ?DateTimeImmutable
    {
        return $this->sourceCreatedAt;
    }

    public function setSourceCreatedAt(?DateTimeImmutable $sourceCreatedAt): self
    {
        $this->sourceCreatedAt = $sourceCreatedAt;

        return $this;
    }

}
