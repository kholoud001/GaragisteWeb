<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportPartRepository::class)]
class ReportPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    // Many-to-one relationship with Report
    #[ORM\ManyToOne(targetEntity: Report::class, inversedBy: "reportParts")]
    #[ORM\JoinColumn(nullable: false)]
    private $report;

    // Many-to-one relationship with Part
    #[ORM\ManyToOne(targetEntity: Part::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $part;

    // Additional fields for damage and damage image
    #[ORM\Column(type: 'text', nullable: true)]
    private $damage;

    #[ORM\Column(type: 'text', nullable: true)]
    private $damageImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(?Report $report): self
    {
        $this->report = $report;
        return $this;
    }

    public function getPart(): ?Part
    {
        return $this->part;
    }

    public function setPart(?Part $part): self
    {
        $this->part = $part;
        return $this;
    }

    public function getDamage(): ?string
    {
        return $this->damage;
    }

    public function setDamage(?string $damage): self
    {
        $this->damage = $damage;
        return $this;
    }

    public function getDamageImage(): ?string
    {
        return $this->damageImage;
    }

    public function setDamageImage(?string $damageImage): self
    {
        $this->damageImage = $damageImage;
        return $this;
    }
}
