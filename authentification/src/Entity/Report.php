<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $registrationNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $previousRegistration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstRegistration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $MC_maroc = null;

    #[ORM\Column(length: 255)]
    private ?string $usage = null;

    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validity_end = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $fuel_type = null;

    #[ORM\Column(length: 255)]
    private ?string $chassis_nbr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cylinder_nbr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fiscal_power = null;

    


    // the collection of parts
    #[ORM\ManyToMany(targetEntity: Part::class)]
    #[ORM\JoinTable(name: "report_part")]


    // private Collection $parts;

    // // Additional fields for damage and damage image
    // #[ORM\Column(type: 'text', nullable: true)]
    // private ?string $damage;

    // #[ORM\Column(type: 'text', nullable: true)]
    // private ?string $damageImage;

    // Many-to-many relationship with Part through ReportPart
    #[ORM\OneToMany(mappedBy: "report", targetEntity: ReportPart::class)]
    private $reportParts;

    // Association to Model
    #[ORM\ManyToOne(targetEntity: Model::class, inversedBy: "reports")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;



    public function __construct()
    {
        $this->parts = new ArrayCollection();
        $this->reportParts = new ArrayCollection();


    }


    //model 
    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    public function getPreviousRegistration(): ?string
    {
        return $this->previousRegistration;
    }

    public function setPreviousRegistration(string $previousRegistration): self
    {
        $this->previousRegistration = $previousRegistration;
        return $this;
    }

    public function getFirstRegistration(): ?\DateTimeInterface
    {
        return $this->firstRegistration;
    }

    public function setFirstRegistration(\DateTimeInterface $firstRegistration): self
    {
        $this->firstRegistration = $firstRegistration;
        return $this;
    }

    public function getMCMaroc(): ?\DateTimeInterface
    {
        return $this->MC_maroc;
    }

    public function setMCMaroc(\DateTimeInterface $MC_maroc): self
    {
        $this->MC_maroc = $MC_maroc;
        return $this;
    }

    public function getUsage(): ?string
    {
        return $this->usage;
    }

    public function setUsage(string $usage): self
    {
        $this->usage = $usage;
        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getValidityEnd(): ?\DateTimeInterface
    {
        return $this->validity_end;
    }

    public function setValidityEnd(\DateTimeInterface $validity_end): self
    {
        $this->validity_end = $validity_end;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuel_type;
    }

    public function setFuelType(string $fuel_type): self
    {
        $this->fuel_type = $fuel_type;
        return $this;
    }

    public function getChassisNbr(): ?string
    {
        return $this->chassis_nbr;
    }

    public function setChassisNbr(string $chassis_nbr): self
    {
        $this->chassis_nbr = $chassis_nbr;
        return $this;
    }

    public function getCylinderNbr(): ?string
    {
        return $this->cylinder_nbr;
    }

    public function setCylinderNbr(?string $cylinder_nbr): self
    {
        $this->cylinder_nbr = $cylinder_nbr;
        return $this;
    }

    public function getFiscalPower(): ?string
    {
        return $this->fiscal_power;
    }

    public function setFiscalPower(?string $fiscal_power): self
    {
        $this->fiscal_power = $fiscal_power;
        return $this;
    }

    
    //Methods for the collection of Parts
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(Part $part): self
    {
        if (!$this->parts->contains($part)) {
            $this->parts[] = $part;
        }
        return $this;
    }

    public function removePart(Part $part): self
    {
        $this->parts->removeElement($part);
        return $this;
    }

    // Getters and setters for damage and damageImage
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

    // Getters and setters for reportParts collection
    public function getReportParts(): Collection
    {
        return $this->reportParts;
    }

    public function addReportPart(ReportPart $reportPart): self
    {
        if (!$this->reportParts->contains($reportPart)) {
            $this->reportParts[] = $reportPart;
            $reportPart->setReport($this);
        }
        return $this;
    }

    public function removeReportPart(ReportPart $reportPart): self
    {
        if ($this->reportParts->removeElement($reportPart)) {
            if ($reportPart->getReport() === $this) {
                $reportPart->setReport(null);
            }
        }
        return $this;
    }
}

