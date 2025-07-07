<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata as Api;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['company_read']],
    denormalizationContext: ['groups' => ['company_write']],
    security: 'is_granted("ROLE_RECRUTEUR")',
)]
#[Api\Get()]
#[Api\Post()]
#[Api\Patch()]
#[Api\Delete()]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le nom de l'entreprise est obligatoire.")]
    #[Groups(['company_read', 'company_write'])]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['company_read', 'company_write'])]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['company_read', 'company_write'])]
    private ?string $city = null;

    /**
     * @var Collection<int, JobOffer>
     */
    #[ORM\OneToMany(targetEntity: JobOffer::class, mappedBy: 'company', orphanRemoval: true)]
    private Collection $jobOffers;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['company_read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: false)]
    #[Groups(['company_read', 'company_write'])]
    private ?BusinessLine $businessLine = null;

    public function __construct()
    {
        $this->jobOffers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getname() ?? '[Company]';
    }

    /**
     * @return Collection<int, JobOffer>
     */
    public function getJobOffers(): Collection
    {
        return $this->jobOffers;
    }

    public function addJobOffer(JobOffer $jobOffer): static
    {
        if (!$this->jobOffers->contains($jobOffer)) {
            $this->jobOffers->add($jobOffer);
            $jobOffer->setCompany($this);
        }

        return $this;
    }

    public function removeJobOffer(JobOffer $jobOffer): static
    {
        if ($this->jobOffers->removeElement($jobOffer)) {
            // set the owning side to null (unless already changed)
            if ($jobOffer->getCompany() === $this) {
                $jobOffer->setCompany(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBusinessLine(): ?BusinessLine
    {
        return $this->businessLine;
    }

    public function setBusinessLine(?BusinessLine $businessLine): static
    {
        $this->businessLine = $businessLine;

        return $this;
    }
}
