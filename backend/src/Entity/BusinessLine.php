<?php

namespace App\Entity;

use App\Repository\BusinessLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata as Api;

#[ORM\Entity(repositoryClass: BusinessLineRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['businessLine_read']],
    denormalizationContext: ['groups' => ['businessLine_write']],
    security: 'is_granted("ROLE_RECRUTEUR")',
)]
#[Api\Get()]
#[Api\Post()]
#[Api\Patch()]
#[Api\Delete()]
class BusinessLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['businessLine_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups(['businessLine_read', 'businessLine_write'])]
    #[Assert\NotBlank(message: "Business line name is required.")]
    private ?string $name = null;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\OneToMany(targetEntity: Company::class, mappedBy: 'businessLine', orphanRemoval: true)]
    private Collection $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->setBusinessLine($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getBusinessLine() === $this) {
                $company->setBusinessLine(null);
            }
        }

        return $this;
    }
}
